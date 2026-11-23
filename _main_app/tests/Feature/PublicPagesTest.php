<?php

namespace Tests\Feature;

use Database\Seeders\GameModeSeeder;
use Database\Seeders\LuxuryEliteRosterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(GameModeSeeder::class);
        $this->seed(LuxuryEliteRosterSeeder::class);
    }

    public function test_home_page_returns_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('LUXURY');
        $response->assertSee('ELITE');
        $response->assertSee('LX Warfare Battalion');
    }

    public function test_roster_page_returns_all_modes_and_warfare_hierarchy(): void
    {
        $response = $this->get('/roster');

        $response->assertStatus(200);
        $response->assertSee('LX Warfare Battalion');
        $response->assertSee('LX Warfare - Team 1');
        $response->assertSee('LX Warfare - Team 5');
        $response->assertSee('UNLIMITED SUBSTITUTES');
        $response->assertSee('iRzell`LX');
        $response->assertSee('BLAZE');
    }

    public function test_roster_page_mode_filters(): void
    {
        $response = $this->get('/roster?mode=warfare');
        $response->assertStatus(200);
        $response->assertSee('PRIMARY WARFARE FORMATION');

        $responseCasual = $this->get('/roster?mode=casual');
        $responseCasual->assertStatus(200);
        $responseCasual->assertSee('STORM');
    }

    public function test_matches_page_returns_successful_response(): void
    {
        $response = $this->get('/matches');

        $response->assertStatus(200);
        $response->assertSee('MATCH CENTER');
        $response->assertSee('UPCOMING SCHEDULED ENGAGEMENTS');
    }
}
