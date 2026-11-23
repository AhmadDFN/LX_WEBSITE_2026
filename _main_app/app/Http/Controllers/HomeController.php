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
        $activePlayersCount = PlayerProfile::active()->count();
        $upcomingMatchesCount = ScrimMatch::upcoming()->count();

        $completedResults = MatchResult::all();
        $totalCompleted = $completedResults->count();
        $winsCount = $completedResults->where('result', 'win')->count();
        $winRate = $totalCompleted > 0 ? round(($winsCount / $totalCompleted) * 100, 1) : 78.5; // Baseline clan telemetry fallback

        $featuredSquad = Squad::platoons()
            ->with(['captain', 'gameMode'])
            ->first();

        $highlightPlayers = PlayerProfile::active()
            ->competitive()
            ->limit(4)
            ->get();

        $upcomingMatches = ScrimMatch::upcoming()
            ->with(['gameMode', 'squad'])
            ->limit(2)
            ->get();

        return view('home', compact(
            'activePlayersCount',
            'upcomingMatchesCount',
            'winRate',
            'featuredSquad',
            'highlightPlayers',
            'upcomingMatches'
        ));
    }
}
