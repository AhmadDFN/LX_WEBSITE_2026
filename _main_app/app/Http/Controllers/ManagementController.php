<?php

namespace App\Http\Controllers;

use App\Models\GameMode;
use App\Models\PlayerProfile;
use App\Models\RecruitmentApplication;
use App\Models\ScrimMatch;
use App\Models\Squad;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ManagementController extends Controller
{
    public function createScrim(): View
    {
        $gameModes = GameMode::where('is_active', true)->get();
        $squads = Squad::with('gameMode')->orderBy('squad_name')->get();

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

        return redirect()->route('matches.show', $scrim->id)->with('status', [
            'type' => 'success',
            'code' => 'ENGAGEMENT_SCHEDULED',
            'message' => 'New competitive fixture registered against ' . $scrim->opponent_name . '.',
        ]);
    }

    public function applicationsIndex(): View
    {
        $applications = RecruitmentApplication::with('targetGameMode')
            ->orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END")
            ->orderByDesc('created_at')
            ->get();

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
