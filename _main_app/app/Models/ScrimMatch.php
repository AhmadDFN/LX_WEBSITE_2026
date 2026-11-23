<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ScrimMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_mode_id',
        'squad_id',
        'opponent_name',
        'opponent_logo',
        'match_type',
        'match_date',
        'match_time',
        'format',
        'room_id',
        'room_password',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'match_date' => 'date',
        ];
    }

    public function gameMode(): BelongsTo
    {
        return $this->belongsTo(GameMode::class);
    }

    public function squad(): BelongsTo
    {
        return $this->belongsTo(Squad::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(ScrimAttendance::class);
    }

    public function result(): HasOne
    {
        return $this->hasOne(MatchResult::class);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('status', 'scheduled')
            ->whereDate('match_date', '>=', now()->toDateString())
            ->orderBy('match_date')
            ->orderBy('match_time');
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed')
            ->orderByDesc('match_date')
            ->orderByDesc('match_time');
    }
}
