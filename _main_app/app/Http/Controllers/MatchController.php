<?php

namespace App\Http\Controllers;

use App\Models\MatchResult;
use App\Models\PlayerProfile;
use App\Models\ScrimAttendance;
use App\Models\ScrimMatch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MatchController extends Controller
{
    public function index(): View
    {
        $upcomingMatches = ScrimMatch::upcoming()
            ->with([
                'gameMode',
                'squad',
                'attendances.playerProfile',
            ])
            ->get();

        $completedMatches = MatchResult::with([
            'scrimMatch.gameMode',
            'scrimMatch.squad',
            'mvpPlayer',
        ])
        ->orderByDesc('created_at')
        ->get();

        return view('matches.index', compact(
            'upcomingMatches',
            'completedMatches'
        ));
    }

    public function show(int $id): View
    {
        $match = ScrimMatch::with([
            'gameMode',
            'squad.parentSquad',
            'squad.subTeams.squadMembers.playerProfile',
            'squad.squadMembers.playerProfile',
            'attendances.playerProfile',
            'result.mvpPlayer',
        ])->findOrFail($id);

        $attendances = $match->attendances;
        $attending = $attendances->where('status', 'attending');
        $tentative = $attendances->where('status', 'tentative');
        $absent = $attendances->where('status', 'absent');

        // Identify if any designated starter is marked absent
        $absentPlayerProfileIds = $absent->pluck('player_profile_id')->toArray();

        $squad = $match->squad;
        $missingStarters = collect();
        $availableReserves = collect();

        if ($squad) {
            // Starters from main squad or child sub-teams
            $starters = $squad->squadMembers->where('slot_type', 'starter');
            foreach ($squad->subTeams as $sub) {
                $starters = $starters->merge($sub->squadMembers->where('slot_type', 'starter'));
            }

            $missingStarters = $starters->filter(function ($member) use ($absentPlayerProfileIds) {
                return in_array($member->player_profile_id, $absentPlayerProfileIds);
            });

            // Available substitute / reserve pool members who are not absent
            $availableReserves = $squad->squadMembers
                ->whereIn('slot_type', ['substitute', 'reserve'])
                ->filter(function ($member) use ($absentPlayerProfileIds) {
                    return !in_array($member->player_profile_id, $absentPlayerProfileIds);
                });
        }

        // Active players eligible to RSVP
        $allPlayers = PlayerProfile::active()->orderBy('ign')->get();

        return view('matches.show', compact(
            'match',
            'attending',
            'tentative',
            'absent',
            'missingStarters',
            'availableReserves',
            'allPlayers'
        ));
    }

    public function rsvp(Request $request, int $id): RedirectResponse
    {
        $match = ScrimMatch::findOrFail($id);

        $validated = $request->validate([
            'player_profile_id' => ['required', 'exists:player_profiles,id'],
            'status' => ['required', 'in:attending,tentative,absent'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        if (in_array($validated['status'], ['tentative', 'absent']) && empty($validated['reason'])) {
            $validated['reason'] = $validated['status'] === 'absent' ? 'Unavailable due to real-life conflict' : 'Pending confirmation';
        }

        ScrimAttendance::updateOrCreate(
            [
                'scrim_match_id' => $match->id,
                'player_profile_id' => $validated['player_profile_id'],
            ],
            [
                'status' => $validated['status'],
                'reason' => $validated['reason'] ?? null,
                'responded_at' => now(),
            ]
        );

        $statusColor = $validated['status'] === 'attending' ? 'success' : ($validated['status'] === 'absent' ? 'warning' : 'info');

        return redirect()->route('matches.show', $match->id)->with('status', [
            'type' => $statusColor,
            'code' => 'TELEMETRY_UPDATED',
            'message' => 'Attendance status recorded successfully for Scrim ID #' . $match->id . '.',
        ]);
    }
}
