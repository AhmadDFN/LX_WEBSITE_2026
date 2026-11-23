<?php

namespace App\Http\Controllers;

use App\Models\MatchResult;
use App\Models\PlayerProfile;
use App\Models\ScrimMatch;
use App\Models\Squad;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        try {
            $activePlayersCount = PlayerProfile::active()->count();
            $upcomingMatchesCount = ScrimMatch::upcoming()->count();

            $completedResults = MatchResult::all();
            $totalCompleted = $completedResults->count();
            $winsCount = $completedResults->where('result', 'win')->count();
            $winRate = $totalCompleted > 0 ? round(($winsCount / $totalCompleted) * 100, 1) : 78.5;

            $featuredSquad = Squad::platoons()
                ->with(['captain', 'gameMode'])
                ->first();

            $dbPlayers = PlayerProfile::active()
                ->limit(7)
                ->get();
        } catch (\Throwable $e) {
            $activePlayersCount = 18;
            $upcomingMatchesCount = 3;
            $winRate = 78.5;
            $featuredSquad = null;
            $dbPlayers = collect();
        }

        $defaultRoster = [
            [
                'nickname' => 'iRzell`LX',
                'role' => 'Assault',
                'image' => '/images/irzell.png',
                'status' => 'Active',
            ],
            [
                'nickname' => 'SHADOW',
                'role' => 'Recon',
                'image' => '/images/irzell.png',
                'status' => 'Active',
            ],
            [
                'nickname' => 'REAPER',
                'role' => 'Medic',
                'image' => '/images/irzell.png',
                'status' => 'Trial',
            ],
            [
                'nickname' => 'GHOST',
                'role' => 'Vehicle',
                'image' => '/images/irzell.png',
                'status' => 'Active',
            ],
            [
                'nickname' => 'VIPER',
                'role' => 'Support',
                'image' => '/images/irzell.png',
                'status' => 'Active',
            ],
            [
                'nickname' => 'BLAZE',
                'role' => 'Assault',
                'image' => '/images/irzell.png',
                'status' => 'Trial',
            ],
            [
                'nickname' => 'STORM',
                'role' => 'Recon',
                'image' => '/images/irzell.png',
                'status' => 'Active',
            ],
        ];

        $players = $defaultRoster;
        if (isset($dbPlayers) && $dbPlayers->isNotEmpty()) {
            $mapped = $dbPlayers->map(function ($player) {
                $status = ($player->player_type === 'trial') ? 'Trial' : ucfirst($player->status ?? 'Active');
                return [
                    'nickname' => $player->ign,
                    'role' => ucfirst($player->preferred_class ?? 'Operator'),
                    'image' => $player->photo_path ? asset('storage/' . $player->photo_path) : '/images/irzell.png',
                    'status' => $status,
                ];
            })->toArray();

            if (count($mapped) >= 4) {
                $players = $mapped;
            }
        }

        return view('home', compact(
            'activePlayersCount',
            'upcomingMatchesCount',
            'winRate',
            'featuredSquad',
            'players'
        ));
    }

    public function trophies(): View
    {
        try {
            $tournaments = \App\Models\Tournament::with(['gameMode', 'squad', 'matches'])
                ->where(function ($q) {
                    $q->where('status', 'completed')
                      ->orWhereNotNull('placement');
                })
                ->orderByDesc('end_date')
                ->get();
        } catch (\Throwable $e) {
            $tournaments = collect();
        }

        return view('trophies.index', compact('tournaments'));
    }
}

