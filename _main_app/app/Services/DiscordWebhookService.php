<?php

namespace App\Services;

use App\Models\RecruitmentApplication;
use App\Models\ScrimMatch;
use App\Models\TournamentMatch;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DiscordWebhookService
{
    /**
     * Send rich embed notification when a new Scrim is scheduled
     */
    public static function notifyScrimScheduled(ScrimMatch $scrim): void
    {
        $webhookUrl = config('services.discord.scrim_webhook') ?? env('DISCORD_SCRIM_WEBHOOK_URL');

        if (empty($webhookUrl)) {
            return;
        }

        try {
            Http::timeout(5)->post($webhookUrl, [
                'username' => 'Luxury Elite Tactical HQ',
                'avatar_url' => url('/images/logo-lx.png'),
                'embeds' => [
                    [
                        'title' => '⚔️ NEW COMPETITIVE SCRIM SCHEDULED',
                        'description' => "Luxury Elite has scheduled an official engagement against **{$scrim->opponent_name}**.",
                        'color' => 0xD4AF37, // Luxury Gold Hex
                        'fields' => [
                            [
                                'name' => '📅 Match Date & Time',
                                'value' => ($scrim->match_date?->format('d M Y') ?? 'TBA') . ' • ' . substr($scrim->match_time, 0, 5) . ' WIB',
                                'inline' => true,
                            ],
                            [
                                'name' => '🎮 Game Mode',
                                'value' => $scrim->gameMode->name ?? 'Delta Force',
                                'inline' => true,
                            ],
                            [
                                'name' => '⚡ Match Format',
                                'value' => $scrim->format,
                                'inline' => true,
                            ],
                            [
                                'name' => '🛡️ Squad Deployed',
                                'value' => $scrim->squad->squad_name ?? 'Main Roster',
                                'inline' => true,
                            ],
                            [
                                'name' => '📋 Action Required',
                                'value' => '[Klik di sini untuk submit RSVP Hadir / Izin](' . route('matches.show', $scrim->id) . ')',
                                'inline' => false,
                            ],
                        ],
                        'footer' => [
                            'text' => 'Luxury Elite Tactical Telemetry System',
                        ],
                        'timestamp' => now()->toIso8601String(),
                    ],
                ],
            ]);
        } catch (\Throwable $e) {
            Log::warning('Discord Scrim webhook dispatch failed: ' . $e->getMessage());
        }
    }

    /**
     * Send alert when a new Tryout / Recruitment application is submitted
     */
    public static function notifyNewRecruitment(RecruitmentApplication $app): void
    {
        $webhookUrl = config('services.discord.recruitment_webhook') ?? env('DISCORD_RECRUITMENT_WEBHOOK_URL');

        if (empty($webhookUrl)) {
            return;
        }

        try {
            Http::timeout(5)->post($webhookUrl, [
                'username' => 'LX Recruitment Bot',
                'avatar_url' => url('/images/logo-lx.png'),
                'embeds' => [
                    [
                        'title' => '📋 NEW RECRUITMENT APPLICATION RECEIVED',
                        'description' => "Operator **{$app->ign}** has submitted an application to join Luxury Elite.",
                        'color' => 0x38BDF8, // Cyan Blue Hex
                        'fields' => [
                            [
                                'name' => '👤 In-Game Name (IGN)',
                                'value' => $app->ign,
                                'inline' => true,
                            ],
                            [
                                'name' => '🆔 Delta Force UID',
                                'value' => $app->delta_force_uid,
                                'inline' => true,
                            ],
                            [
                                'name' => '🎯 Preferred Class',
                                'value' => strtoupper($app->preferred_class),
                                'inline' => true,
                            ],
                            [
                                'name' => '🏆 Current Rank Tier',
                                'value' => $app->rank_tier,
                                'inline' => true,
                            ],
                            [
                                'name' => '💬 Discord Tag',
                                'value' => $app->discord_tag,
                                'inline' => true,
                            ],
                            [
                                'name' => '🔍 Review Dossier',
                                'value' => '[Buka Recruitment Triage Management](' . route('management.applications.index') . ')',
                                'inline' => false,
                            ],
                        ],
                        'footer' => [
                            'text' => 'Luxury Elite Recruitment Pipeline',
                        ],
                        'timestamp' => now()->toIso8601String(),
                    ],
                ],
            ]);
        } catch (\Throwable $e) {
            Log::warning('Discord Recruitment webhook dispatch failed: ' . $e->getMessage());
        }
    }

    /**
     * Send celebration alert when tournament match is won
     */
    public static function notifyTournamentVictory(TournamentMatch $match): void
    {
        $webhookUrl = config('services.discord.scrim_webhook') ?? env('DISCORD_SCRIM_WEBHOOK_URL');

        if (empty($webhookUrl)) {
            return;
        }

        try {
            Http::timeout(5)->post($webhookUrl, [
                'username' => 'Luxury Elite Victory Broadcast',
                'avatar_url' => url('/images/logo-lx.png'),
                'embeds' => [
                    [
                        'title' => '🏆 TOURNAMENT VICTORY SECURED!',
                        'description' => "Luxury Elite has won **{$match->round_name}** in {$match->tournament->name} against **{$match->opponent_name}**!",
                        'color' => 0x10B981, // Emerald Green
                        'fields' => [
                            [
                                'name' => '📊 Score',
                                'value' => "Luxury Elite **{$match->our_score}** - **{$match->opponent_score}** {$match->opponent_name}",
                                'inline' => true,
                            ],
                            [
                                'name' => '⚔️ Round',
                                'value' => $match->round_name,
                                'inline' => true,
                            ],
                        ],
                        'footer' => [
                            'text' => 'Luxury Elite Tournament Ops',
                        ],
                        'timestamp' => now()->toIso8601String(),
                    ],
                ],
            ]);
        } catch (\Throwable $e) {
            Log::warning('Discord Tournament Victory webhook dispatch failed: ' . $e->getMessage());
        }
    }
}
