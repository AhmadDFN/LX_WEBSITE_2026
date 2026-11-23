<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'organizer',
        'game_mode_id',
        'squad_id',
        'prize_pool',
        'tournament_format',
        'start_date',
        'end_date',
        'status',
        'placement',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
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

    public function matches(): HasMany
    {
        return $this->hasMany(TournamentMatch::class)->orderBy('match_order');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', ['upcoming', 'ongoing']);
    }
}
