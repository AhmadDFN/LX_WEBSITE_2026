<?php

namespace App\Http\Controllers;

use App\Models\GameMode;
use App\Models\PlayerProfile;
use App\Models\Squad;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RosterController extends Controller
{
    public function index(Request $request): View
    {
        $selectedMode = $request->query('mode', 'all');

        $warfarePlatoon = null;
        $detonationSquads = collect();
        $hazardSquads = collect();
        $casualPlayers = collect();
        $allPlayers = collect();

        // 1. Havoc Warfare (20v20)
        if (in_array($selectedMode, ['all', 'warfare'])) {
            $warfarePlatoon = Squad::platoons()
                ->whereHas('gameMode', fn ($q) => $q->where('slug', 'havoc-warfare'))
                ->with([
                    'captain',
                    'gameMode',
                    'subTeams' => fn ($q) => $q->orderBy('team_number')->with([
                        'captain',
                        'squadMembers.playerProfile',
                    ]),
                    'squadMembers.playerProfile',
                ])
                ->first();
        }

        // 2. Detonation (5v5)
        if (in_array($selectedMode, ['all', 'detonation'])) {
            $detonationSquads = Squad::whereNull('parent_squad_id')
                ->whereHas('gameMode', fn ($q) => $q->where('slug', 'detonation'))
                ->with([
                    'captain',
                    'gameMode',
                    'squadMembers.playerProfile',
                ])
                ->get();
        }

        // 3. Hazard Operations (3v3)
        if (in_array($selectedMode, ['all', 'hazard'])) {
            $hazardSquads = Squad::whereNull('parent_squad_id')
                ->whereHas('gameMode', fn ($q) => $q->where('slug', 'hazard-operations'))
                ->with([
                    'captain',
                    'gameMode',
                    'squadMembers.playerProfile',
                ])
                ->get();
        }

        // 4. Casual Members
        if (in_array($selectedMode, ['all', 'casual'])) {
            $casualPlayers = PlayerProfile::active()
                ->casual()
                ->orderBy('ign')
                ->get();
        }

        // 5. All Players fallback list if 'all' mode
        if ($selectedMode === 'all') {
            $allPlayers = PlayerProfile::active()
                ->orderBy('player_type')
                ->orderBy('ign')
                ->get();
        }

        $gameModes = GameMode::where('is_active', true)->get();

        return view('roster.index', compact(
            'selectedMode',
            'warfarePlatoon',
            'detonationSquads',
            'hazardSquads',
            'casualPlayers',
            'allPlayers',
            'gameModes'
        ));
    }
}
