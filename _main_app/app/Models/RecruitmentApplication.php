<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecruitmentApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'ign',
        'delta_force_uid',
        'discord_tag',
        'target_game_mode_id',
        'preferred_class',
        'rank_tier',
        'proof_screenshot',
        'status',
        'reviewer_notes',
    ];

    public function targetGameMode(): BelongsTo
    {
        return $this->belongsTo(GameMode::class, 'target_game_mode_id');
    }
}
