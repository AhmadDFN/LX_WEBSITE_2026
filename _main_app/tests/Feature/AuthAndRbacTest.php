<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\GameModeSeeder;
use Database\Seeders\LuxuryEliteRosterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndRbacTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(GameModeSeeder::class);
        $this->seed(LuxuryEliteRosterSeeder::class);
    }

    public function test_guest_can_view_login_page(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('TERMINAL');
        $response->assertSee('AUTHENTICATION');
    }

    public function test_unauthenticated_user_cannot_access_dashboard_or_management(): void
    {
        $responseDashboard = $this->get('/dashboard');
        $responseDashboard->assertRedirect('/login');

        $responseManagement = $this->get('/management/applications');
        $responseManagement->assertRedirect('/login');
    }

    public function test_successful_login_redirects_to_dashboard(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@luxuryelite.web.id',
            'password' => 'password123',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_regular_player_cannot_access_management_sector(): void
    {
        $playerUser = User::where('email', 'irzell@luxuryelite.web.id')->first();
        $this->assertNotNull($playerUser);

        // Player accessing dashboard -> OK
        $responseDashboard = $this->actingAs($playerUser)->get('/dashboard');
        $responseDashboard->assertStatus(200);
        $responseDashboard->assertSee('OPERATOR DOSSIER');
        $responseDashboard->assertSee('iRzell`LX');

        // Player accessing management -> 403 Forbidden
        $responseManagement = $this->actingAs($playerUser)->get('/management/applications');
        $responseManagement->assertStatus(403);
    }

    public function test_staff_roles_can_access_management_sector(): void
    {
        $adminUser = User::where('email', 'admin@luxuryelite.web.id')->first();
        $this->assertNotNull($adminUser);

        $responseAdmin = $this->actingAs($adminUser)->get('/management/applications');
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertSee('RECRUITMENT APPLICATION TRIAGE');

        $coachUser = User::where('email', 'coach@luxuryelite.web.id')->first();
        $this->assertNotNull($coachUser);

        $responseCoach = $this->actingAs($coachUser)->get('/management/scrims/create');
        $responseCoach->assertStatus(200);
        $responseCoach->assertSee('SCHEDULE NEW SCRIM');
    }

    public function test_authenticated_user_can_logout(): void
    {
        $adminUser = User::where('email', 'admin@luxuryelite.web.id')->first();

        $response = $this->actingAs($adminUser)->post('/logout');
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
