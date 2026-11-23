<?php

namespace Tests\Feature;

use App\Models\GameMode;
use App\Models\PlayerProfile;
use App\Models\RecruitmentApplication;
use App\Models\ScrimAttendance;
use App\Models\ScrimMatch;
use Database\Seeders\GameModeSeeder;
use Database\Seeders\LuxuryEliteRosterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InteractiveFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(GameModeSeeder::class);
        $this->seed(LuxuryEliteRosterSeeder::class);
    }

    public function test_can_view_join_squad_form(): void
    {
        $response = $this->get('/join-squad');
        $response->assertStatus(200);
        $response->assertSee('JOIN');
        $response->assertSee('LUXURY ELITE');
    }

    public function test_can_submit_recruitment_application(): void
    {
        Storage::fake('public');

        $gameMode = GameMode::first();
        $file = UploadedFile::fake()->image('stat_proof.png');

        $response = $this->post('/join-squad', [
            'full_name' => 'Alex Thorne',
            'ign' => 'THORNE`LX',
            'delta_force_uid' => 'LX-999001',
            'discord_tag' => 'alex_thorne#1111',
            'target_game_mode_id' => $gameMode->id,
            'preferred_class' => 'assault',
            'rank_tier' => 'Pinnacle',
            'proof_screenshot' => $file,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/join-squad');

        $this->assertDatabaseHas('recruitment_applications', [
            'ign' => 'THORNE`LX',
            'delta_force_uid' => 'LX-999001',
            'status' => 'pending',
        ]);
    }

    public function test_can_view_scrim_inspection_and_submit_rsvp(): void
    {
        $gameMode = GameMode::first();
        $scrim = ScrimMatch::create([
            'game_mode_id' => $gameMode->id,
            'opponent_name' => 'Viper Strike Esports',
            'match_type' => 'scrim',
            'match_date' => now()->addDays(2)->toDateString(),
            'match_time' => '20:30',
            'format' => 'BO3',
            'room_id' => 'ROOM-ASIA-01',
            'room_password' => 'secretpass',
            'status' => 'scheduled',
        ]);

        $response = $this->get("/matches/{$scrim->id}");
        $response->assertStatus(200);
        $response->assertSee('Viper Strike Esports');
        $response->assertSee('SUBMIT PLAYER ATTENDANCE');

        $player = PlayerProfile::first();

        // Submit RSVP Attendance
        $rsvpResponse = $this->post("/matches/{$scrim->id}/rsvp", [
            'player_profile_id' => $player->id,
            'status' => 'attending',
            'reason' => 'Combat Ready',
        ]);

        $rsvpResponse->assertStatus(302);
        $rsvpResponse->assertRedirect("/matches/{$scrim->id}");

        $this->assertDatabaseHas('scrim_attendances', [
            'scrim_match_id' => $scrim->id,
            'player_profile_id' => $player->id,
            'status' => 'attending',
        ]);
    }

    public function test_can_schedule_scrim_from_management(): void
    {
        $admin = \App\Models\User::where('email', 'admin@luxuryelite.web.id')->first();
        $gameMode = GameMode::first();

        $response = $this->actingAs($admin)->post('/management/scrims', [
            'game_mode_id' => $gameMode->id,
            'opponent_name' => 'Ghost Recon Division',
            'match_type' => 'scrim',
            'match_date' => now()->addDays(3)->toDateString(),
            'match_time' => '21:00',
            'format' => 'BO3',
            'room_id' => 'ROOM-102',
            'room_password' => 'pass123',
            'notes' => 'Delta Force Havoc Warfare rules applied.',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('scrim_matches', [
            'opponent_name' => 'Ghost Recon Division',
            'room_id' => 'ROOM-102',
        ]);
    }

    public function test_can_approve_recruitment_application_as_trial(): void
    {
        $admin = \App\Models\User::where('email', 'admin@luxuryelite.web.id')->first();
        $gameMode = GameMode::first();
        $app = RecruitmentApplication::create([
            'full_name' => 'Kaelen Vance',
            'ign' => 'VANCE`LX',
            'delta_force_uid' => 'LX-777002',
            'discord_tag' => 'vance#2222',
            'target_game_mode_id' => $gameMode->id,
            'preferred_class' => 'recon',
            'rank_tier' => 'Pinnacle',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post("/management/applications/{$app->id}/process", [
            'action' => 'approve_trial',
            'reviewer_notes' => 'Exceptional KD performance. Approved for Trial squad.',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('recruitment_applications', [
            'id' => $app->id,
            'status' => 'accepted_trial',
        ]);

        // Verify PlayerProfile and User created
        $this->assertDatabaseHas('player_profiles', [
            'ign' => 'VANCE`LX',
            'player_type' => 'trial',
        ]);
    }
}
