<?php

namespace App\Http\Controllers;

use App\Models\GameMode;
use App\Models\MatchResult;
use App\Models\PlayerProfile;
use App\Models\RecruitmentApplication;
use App\Models\ScrimMatch;
use App\Models\Squad;
use App\Models\SquadMember;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ManagementController extends Controller
{
    /**
     * Management Command Overview
     */
    public function dashboard(): View
    {
        try {
            $totalPlayers = PlayerProfile::count();
            $activePlayers = PlayerProfile::where('status', 'active')->count();
            $pendingApplications = RecruitmentApplication::where('status', 'pending')->count();
            $upcomingScrimsCount = ScrimMatch::where('status', 'scheduled')->count();
            $recentScrims = ScrimMatch::with(['gameMode', 'squad', 'result'])
                ->orderByDesc('match_date')
                ->take(5)
                ->get();
            $tournamentsCount = class_exists(Tournament::class) && DB::getSchemaBuilder()->hasTable('tournaments')
                ? Tournament::whereIn('status', ['upcoming', 'ongoing'])->count()
                : 0;
            $recentTournaments = class_exists(Tournament::class) && DB::getSchemaBuilder()->hasTable('tournaments')
                ? Tournament::with(['gameMode', 'squad'])->orderByDesc('created_at')->take(4)->get()
                : collect();
        } catch (\Throwable $e) {
            $totalPlayers = 0;
            $activePlayers = 0;
            $pendingApplications = 0;
            $upcomingScrimsCount = 0;
            $recentScrims = collect();
            $tournamentsCount = 0;
            $recentTournaments = collect();
        }

        return view('management.dashboard', compact(
            'totalPlayers',
            'activePlayers',
            'pendingApplications',
            'upcomingScrimsCount',
            'recentScrims',
            'tournamentsCount',
            'recentTournaments'
        ));
    }

    /**
     * 1. MANAGEMENT PLAYER (Roster Directory & Roles)
     */
    public function playersIndex(Request $request): View
    {
        $tier = $request->query('tier', 'all');
        $search = $request->query('q', '');

        try {
            $query = PlayerProfile::with(['user', 'squads']);

            if ($tier !== 'all') {
                $query->where('player_type', $tier);
            }

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('ign', 'like', "%{$search}%")
                      ->orWhere('delta_force_uid', 'like', "%{$search}%")
                      ->orWhere('discord_tag', 'like', "%{$search}%");
                });
            }

            $players = $query->orderBy('ign')->get();
            $squads = Squad::orderBy('squad_name')->get();
            $allUsers = User::orderBy('name')->get();
        } catch (\Throwable $e) {
            $players = collect();
            $squads = collect();
            $allUsers = collect();
        }

        return view('management.players.index', compact('players', 'squads', 'allUsers', 'tier', 'search'));
    }

    public function updatePlayer(Request $request, int $id): RedirectResponse
    {
        $player = PlayerProfile::findOrFail($id);

        $validated = $request->validate([
            'ign' => ['required', 'string', 'max:100'],
            'delta_force_uid' => ['required', 'string', 'max:50'],
            'player_type' => ['required', 'in:competitive,casual,trial,inactive'],
            'preferred_class' => ['required', 'in:assault,engineer,support,recon'],
            'rank_tier' => ['required', 'string', 'max:50'],
            'discord_tag' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $player->update($validated);

        return redirect()->route('management.players.index')->with('status', [
            'type' => 'success',
            'code' => 'ROSTER_UPDATED',
            'message' => "Player dossier for {$player->ign} has been updated.",
        ]);
    }

    public function updateUserRole(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'role' => ['required', 'in:superadmin,manager,coach,captain,player,casual_member'],
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->route('management.players.index')->with('status', [
            'type' => 'success',
            'code' => 'ROLE_ASSIGNED',
            'message' => "User {$user->name} command privilege updated to {$validated['role']}.",
        ]);
    }

    /**
     * 2. MANAGEMENT SCRIM
     */
    public function scrimsIndex(): View
    {
        try {
            $scrims = ScrimMatch::with(['gameMode', 'squad', 'result', 'attendances.playerProfile'])
                ->orderByDesc('match_date')
                ->orderByDesc('match_time')
                ->get();
            $gameModes = GameMode::where('is_active', true)->get();
            $squads = Squad::orderBy('squad_name')->get();
        } catch (\Throwable $e) {
            $scrims = collect();
            $gameModes = collect();
            $squads = collect();
        }

        return view('management.scrims.index', compact('scrims', 'gameModes', 'squads'));
    }

    public function createScrim(): View
    {
        try {
            $gameModes = GameMode::where('is_active', true)->get();
            $squads = Squad::with('gameMode')->orderBy('squad_name')->get();
        } catch (\Throwable $e) {
            $gameModes = collect();
            $squads = collect();
        }

        return view('management.scrims.create', compact('gameModes', 'squads'));
    }

    public function storeScrim(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'game_mode_id' => ['required', 'exists:game_modes,id'],
            'squad_id' => ['nullable', 'exists:squads,id'],
            'opponent_name' => ['required', 'string', 'max:255'],
            'opponent_logo' => ['nullable', 'string', 'max:255'],
            'match_type' => ['required', 'in:scrim,tournament,exhibition'],
            'match_date' => ['required', 'date'],
            'match_time' => ['required'],
            'format' => ['required', 'in:BO1,BO3,BO5'],
            'room_id' => ['nullable', 'string', 'max:100'],
            'room_password' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        $scrim = ScrimMatch::create([
            'game_mode_id' => $validated['game_mode_id'],
            'squad_id' => $validated['squad_id'] ?? null,
            'opponent_name' => $validated['opponent_name'],
            'opponent_logo' => $validated['opponent_logo'] ?? null,
            'match_type' => $validated['match_type'],
            'match_date' => $validated['match_date'],
            'match_time' => $validated['match_time'],
            'format' => $validated['format'],
            'room_id' => $validated['room_id'] ?? null,
            'room_password' => $validated['room_password'] ?? null,
            'status' => 'scheduled',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('management.scrims.index')->with('status', [
            'type' => 'success',
            'code' => 'ENGAGEMENT_SCHEDULED',
            'message' => 'New competitive fixture registered against ' . $scrim->opponent_name . '.',
        ]);
    }

    public function editScrim(int $id): View
    {
        $scrim = ScrimMatch::with(['gameMode', 'squad', 'result'])->findOrFail($id);
        $gameModes = GameMode::where('is_active', true)->get();
        $squads = Squad::orderBy('squad_name')->get();
        $players = PlayerProfile::where('status', 'active')->orderBy('ign')->get();

        return view('management.scrims.edit', compact('scrim', 'gameModes', 'squads', 'players'));
    }

    public function updateScrim(Request $request, int $id): RedirectResponse
    {
        $scrim = ScrimMatch::findOrFail($id);

        $validated = $request->validate([
            'game_mode_id' => ['required', 'exists:game_modes,id'],
            'squad_id' => ['nullable', 'exists:squads,id'],
            'opponent_name' => ['required', 'string', 'max:255'],
            'opponent_logo' => ['nullable', 'string', 'max:255'],
            'match_type' => ['required', 'in:scrim,tournament,exhibition'],
            'match_date' => ['required', 'date'],
            'match_time' => ['required'],
            'format' => ['required', 'in:BO1,BO3,BO5'],
            'room_id' => ['nullable', 'string', 'max:100'],
            'room_password' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:scheduled,ongoing,completed,canceled'],
            'notes' => ['nullable', 'string'],
        ]);

        $scrim->update($validated);

        return redirect()->route('management.scrims.index')->with('status', [
            'type' => 'success',
            'code' => 'SCRIM_UPDATED',
            'message' => "Scrim details against {$scrim->opponent_name} updated successfully.",
        ]);
    }

    public function storeScrimResult(Request $request, int $id): RedirectResponse
    {
        $scrim = ScrimMatch::findOrFail($id);

        $validated = $request->validate([
            'our_score' => ['required', 'integer', 'min:0'],
            'opponent_score' => ['required', 'integer', 'min:0'],
            'result' => ['required', 'in:victory,defeat,draw'],
            'maps_played' => ['nullable', 'string'], // JSON string or text
            'vod_url' => ['nullable', 'url', 'max:255'],
            'screenshot_url' => ['nullable', 'string', 'max:255'],
            'mvp_player_id' => ['nullable', 'exists:player_profiles,id'],
            'coach_notes' => ['nullable', 'string'],
        ]);

        // Process maps played if JSON or structured text
        $mapsArray = null;
        if (!empty($validated['maps_played'])) {
            $decoded = json_decode($validated['maps_played'], true);
            $mapsArray = is_array($decoded) ? $decoded : [['summary' => $validated['maps_played']]];
        }

        MatchResult::updateOrCreate(
            ['scrim_match_id' => $scrim->id],
            [
                'our_score' => $validated['our_score'],
                'opponent_score' => $validated['opponent_score'],
                'result' => $validated['result'],
                'maps_played' => $mapsArray,
                'vod_url' => $validated['vod_url'] ?? null,
                'screenshot_url' => $validated['screenshot_url'] ?? null,
                'mvp_player_id' => $validated['mvp_player_id'] ?? null,
                'coach_notes' => $validated['coach_notes'] ?? null,
            ]
        );

        $scrim->update(['status' => 'completed']);

        return redirect()->route('management.scrims.index')->with('status', [
            'type' => 'success',
            'code' => 'RESULT_LOGGED',
            'message' => "Match result against {$scrim->opponent_name} ({$validated['our_score']}-{$validated['opponent_score']}) logged and archived.",
        ]);
    }

    public function updateScrimStatus(Request $request, int $id): RedirectResponse
    {
        $scrim = ScrimMatch::findOrFail($id);
        $validated = $request->validate([
            'status' => ['required', 'in:scheduled,ongoing,completed,canceled'],
        ]);

        $scrim->update(['status' => $validated['status']]);

        return redirect()->back()->with('status', [
            'type' => 'info',
            'code' => 'STATUS_CHANGED',
            'message' => "Scrim match status transitioned to {$validated['status']}.",
        ]);
    }

    /**
     * 3. MANAGEMENT TOUR (Tournaments & Brackets)
     */
    public function tournamentsIndex(): View
    {
        try {
            $tournaments = Tournament::with(['gameMode', 'squad', 'matches'])
                ->orderByDesc('start_date')
                ->get();
            $gameModes = GameMode::where('is_active', true)->get();
            $squads = Squad::orderBy('squad_name')->get();
        } catch (\Throwable $e) {
            $tournaments = collect();
            $gameModes = collect();
            $squads = collect();
        }

        return view('management.tournaments.index', compact('tournaments', 'gameModes', 'squads'));
    }

    public function storeTournament(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'organizer' => ['nullable', 'string', 'max:255'],
            'game_mode_id' => ['nullable', 'exists:game_modes,id'],
            'squad_id' => ['nullable', 'exists:squads,id'],
            'prize_pool' => ['nullable', 'string', 'max:100'],
            'tournament_format' => ['required', 'in:single_elimination,double_elimination,group_stage,round_robin,custom'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'status' => ['required', 'in:upcoming,ongoing,completed,canceled'],
            'notes' => ['nullable', 'string'],
        ]);

        $slug = Str::slug($validated['name']) . '-' . date('Ymd-His');

        $tournament = Tournament::create(array_merge($validated, ['slug' => $slug]));

        return redirect()->route('management.tournaments.show', $tournament->id)->with('status', [
            'type' => 'success',
            'code' => 'TOURNAMENT_INITIALIZED',
            'message' => "Tournament {$tournament->name} registered. You can now build brackets and schedule matches.",
        ]);
    }

    public function showTournament(int $id): View
    {
        $tournament = Tournament::with(['gameMode', 'squad', 'matches.squad'])->findOrFail($id);
        $squads = Squad::orderBy('squad_name')->get();

        return view('management.tournaments.show', compact('tournament', 'squads'));
    }

    public function updateTournament(Request $request, int $id): RedirectResponse
    {
        $tournament = Tournament::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'organizer' => ['nullable', 'string', 'max:255'],
            'squad_id' => ['nullable', 'exists:squads,id'],
            'prize_pool' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:upcoming,ongoing,completed,canceled'],
            'placement' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        $tournament->update($validated);

        return redirect()->route('management.tournaments.show', $tournament->id)->with('status', [
            'type' => 'success',
            'code' => 'TOURNAMENT_UPDATED',
            'message' => "Tournament details and standing updated.",
        ]);
    }

    public function storeTournamentMatch(Request $request, int $id): RedirectResponse
    {
        $tournament = Tournament::findOrFail($id);

        $validated = $request->validate([
            'round_name' => ['required', 'string', 'max:100'],
            'match_order' => ['required', 'integer', 'min:1'],
            'opponent_name' => ['required', 'string', 'max:255'],
            'squad_id' => ['nullable', 'exists:squads,id'],
            'our_score' => ['nullable', 'integer', 'min:0'],
            'opponent_score' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:scheduled,ongoing,won,lost'],
            'scheduled_at' => ['nullable', 'date'],
            'stream_url' => ['nullable', 'url', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $tournament->matches()->create($validated);

        return redirect()->route('management.tournaments.show', $tournament->id)->with('status', [
            'type' => 'success',
            'code' => 'FIXTURE_ADDED',
            'message' => "Tournament round {$validated['round_name']} vs {$validated['opponent_name']} registered.",
        ]);
    }

    public function updateTournamentMatch(Request $request, int $id): RedirectResponse
    {
        $match = TournamentMatch::findOrFail($id);

        $validated = $request->validate([
            'our_score' => ['required', 'integer', 'min:0'],
            'opponent_score' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:scheduled,ongoing,won,lost'],
            'stream_url' => ['nullable', 'url', 'max:255'],
            'vod_url' => ['nullable', 'url', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $match->update($validated);

        return redirect()->back()->with('status', [
            'type' => 'success',
            'code' => 'MATCH_SCORED',
            'message' => "Match fixture score updated ({$validated['our_score']}-{$validated['opponent_score']}).",
        ]);
    }

    /**
     * RECRUITMENT TRIAGE
     */
    public function applicationsIndex(): View
    {
        try {
            $applications = RecruitmentApplication::with('targetGameMode')
                ->orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END")
                ->orderByDesc('created_at')
                ->get();
        } catch (\Throwable $e) {
            $applications = collect();
        }

        return view('management.applications.index', compact('applications'));
    }

    public function processApplication(Request $request, int $id): RedirectResponse
    {
        $application = RecruitmentApplication::findOrFail($id);

        $validated = $request->validate([
            'action' => ['required', 'in:approve_trial,reject'],
            'reviewer_notes' => ['nullable', 'string', 'max:500'],
        ]);

        if ($validated['action'] === 'approve_trial') {
            $application->update([
                'status' => 'accepted_trial',
                'reviewer_notes' => $validated['reviewer_notes'] ?? 'Approved for Delta Force Trial Division.',
            ]);

            // Auto-create User & PlayerProfile if not exists
            $email = Str::slug(str_replace('`', '', $application->ign)) . '@luxuryelite.gg';
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $application->ign,
                    'password' => Hash::make('password123'),
                    'role' => 'player',
                    'is_active' => true,
                ]
            );

            PlayerProfile::firstOrCreate(
                ['ign' => $application->ign],
                [
                    'user_id' => $user->id,
                    'delta_force_uid' => $application->delta_force_uid,
                    'player_type' => 'trial',
                    'preferred_class' => $application->preferred_class,
                    'rank_tier' => $application->rank_tier,
                    'discord_tag' => $application->discord_tag,
                    'avatar_url' => $application->proof_screenshot,
                    'status' => 'active',
                ]
            );

            $msg = "Applicant {$application->ign} approved and registered as a Trial Operator.";
        } else {
            $application->update([
                'status' => 'rejected',
                'reviewer_notes' => $validated['reviewer_notes'] ?? 'Application rejected based on current roster criteria.',
            ]);

            $msg = "Application for {$application->ign} marked as rejected.";
        }

        return redirect()->route('management.applications.index')->with('status', [
            'type' => 'info',
            'code' => 'DOSSIER_UPDATED',
            'message' => $msg,
        ]);
    }
}
