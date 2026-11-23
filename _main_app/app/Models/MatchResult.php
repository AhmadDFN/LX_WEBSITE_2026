<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'scrim_match_id',
        'our_score',
        'opponent_score',
        'result',
        'maps_played',
        'vod_url',
        'screenshot_url',
        'mvp_player_id',
        'coach_notes',
    ];

    protected function casts(): array
    {
        return [
            'our_score' => 'integer',
            'opponent_score' => 'integer',
            'maps_played' => 'array',
        ];
    }

    public function scrimMatch(): BelongsTo
    {
        return $this->belongsTo(ScrimMatch::class);
    }

    public function mvpPlayer(): BelongsTo
    {
        return $this->belongsTo(PlayerProfile::class, 'mvp_player_id');
    }
}
