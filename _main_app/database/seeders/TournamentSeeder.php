<?php

namespace Database\Seeders;

use App\Models\GameMode;
use App\Models\Squad;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $detonationMode = GameMode::where('slug', 'detonation')->first();
        $alphaSquad = Squad::where('squad_name', 'like', '%Alpha%')->first();

        // 1. Ongoing Tournament Campaign
        $invitational = Tournament::updateOrCreate(
            ['slug' => 'delta-force-sea-invitational-2026'],
            [
                'name' => 'Delta Force SEA Invitational 2026',
                'organizer' => 'TiMi Studios & Garena SEA',
                'game_mode_id' => $detonationMode?->id,
                'squad_id' => $alphaSquad?->id,
                'prize_pool' => 'Rp 50.000.000',
                'tournament_format' => 'single_elimination',
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(5),
                'status' => 'ongoing',
                'placement' => 'Grand Finalist',
                'notes' => 'Official Southeast Asian Invitational. Detonation 5v5 Mode, Best of 3 format.',
            ]
        );

        // Bracket Fixtures for Invitational
        TournamentMatch::updateOrCreate(
            [
                'tournament_id' => $invitational->id,
                'round_name' => 'Quarter Finals',
            ],
            [
                'match_order' => 1,
                'squad_id' => $alphaSquad?->id,
                'opponent_name' => 'Rex Regum Qeon (RRQ)',
                'our_score' => 2,
                'opponent_score' => 0,
                'status' => 'won',
                'scheduled_at' => now()->subDays(2),
                'stream_url' => 'https://youtube.com',
                'notes' => 'Victory 2-0: Zero Dam (11-7), Brakkesh (11-6). Clean sweep.',
            ]
        );

        TournamentMatch::updateOrCreate(
            [
                'tournament_id' => $invitational->id,
                'round_name' => 'Semi Finals',
            ],
            [
                'match_order' => 2,
                'squad_id' => $alphaSquad?->id,
                'opponent_name' => 'Paper Rex Tactical',
                'our_score' => 2,
                'opponent_score' => 1,
                'status' => 'won',
                'scheduled_at' => now()->subDay(),
                'stream_url' => 'https://youtube.com',
                'notes' => 'Victory 2-1: Clutch round 10 defusal by iRzell on Ascension.',
            ]
        );

        TournamentMatch::updateOrCreate(
            [
                'tournament_id' => $invitational->id,
                'round_name' => 'Grand Final',
            ],
            [
                'match_order' => 3,
                'squad_id' => $alphaSquad?->id,
                'opponent_name' => 'Fnatic SEA',
                'our_score' => 0,
                'opponent_score' => 0,
                'status' => 'scheduled',
                'scheduled_at' => now()->addDays(2),
                'stream_url' => 'https://youtube.com',
                'notes' => 'Grand Final Bo5 showdown. Live on YouTube Esports Channel.',
            ]
        );

        // 2. Completed Tournament Campaign (Trophy Room Showcase)
        $masters = Tournament::updateOrCreate(
            ['slug' => 'indonesia-tactical-masters-season-1'],
            [
                'name' => 'Indonesia Tactical Masters Season 1',
                'organizer' => 'Delta Force Community ID',
                'game_mode_id' => $detonationMode?->id,
                'squad_id' => $alphaSquad?->id,
                'prize_pool' => 'Rp 20.000.000',
                'tournament_format' => 'single_elimination',
                'start_date' => now()->subMonths(1),
                'end_date' => now()->subMonths(1)->addDays(4),
                'status' => 'completed',
                'placement' => 'Champion 1st (Gold Trophy)',
                'notes' => 'Undefeated Championship Run. First national championship trophy secured for Luxury Elite.',
            ]
        );

        TournamentMatch::updateOrCreate(
            [
                'tournament_id' => $masters->id,
                'round_name' => 'Grand Final',
            ],
            [
                'match_order' => 1,
                'squad_id' => $alphaSquad?->id,
                'opponent_name' => 'Aura Esports',
                'our_score' => 3,
                'opponent_score' => 1,
                'status' => 'won',
                'scheduled_at' => now()->subMonths(1)->addDays(4),
                'notes' => 'Grand Final BO5 victory 3-1. Luxury Elite crowned Champions.',
            ]
        );
    }
}
