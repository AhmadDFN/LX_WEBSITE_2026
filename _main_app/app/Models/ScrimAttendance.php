<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScrimAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'scrim_match_id',
        'player_profile_id',
        'status',
        'reason',
        'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
        ];
    }

    public function scrimMatch(): BelongsTo
    {
        return $this->belongsTo(ScrimMatch::class);
    }

    public function playerProfile(): BelongsTo
    {
        return $this->belongsTo(PlayerProfile::class);
    }
}
