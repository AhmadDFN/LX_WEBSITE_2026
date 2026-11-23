<?php

namespace App\Http\Controllers;

use App\Models\PlayerProfile;
use App\Models\RecruitmentApplication;
use App\Models\ScrimAttendance;
use App\Models\ScrimMatch;
use App\Models\Squad;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $isStaff = in_array($user->role, ['superadmin', 'manager', 'coach'], true);

        $playerProfile = $user->playerProfile;
        $activeSquads = collect();
        $personalRsvps = collect();

        if ($playerProfile) {
            $activeSquads = $playerProfile->squads()->with(['gameMode', 'captain'])->get();
            $personalRsvps = ScrimAttendance::where('player_profile_id', $playerProfile->id)
                ->with(['scrimMatch.gameMode'])
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();
        }

        $upcomingScrims = ScrimMatch::upcoming()
            ->with(['gameMode', 'squad'])
            ->limit(4)
            ->get();

        // Staff operational metrics
        $metrics = [];
        if ($isStaff) {
            $metrics = [
                'total_members' => PlayerProfile::active()->count(),
                'pending_recruits' => RecruitmentApplication::where('status', 'pending')->count(),
                'scheduled_scrims' => ScrimMatch::upcoming()->count(),
                'active_squads' => Squad::count(),
            ];
        }

        return view('dashboard', compact(
            'user',
            'isStaff',
            'playerProfile',
            'activeSquads',
            'personalRsvps',
            'upcomingScrims',
            'metrics'
        ));
    }
}
