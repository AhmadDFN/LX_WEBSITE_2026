<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SquadMember extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'squad_members';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    protected $fillable = [
        'squad_id',
        'player_profile_id',
        'slot_type',
        'sub_team_number',
        'role_specialization',
    ];

    protected function casts(): array
    {
        return [
            'sub_team_number' => 'integer',
        ];
    }

    public function squad(): BelongsTo
    {
        return $this->belongsTo(Squad::class);
    }

    public function playerProfile(): BelongsTo
    {
        return $this->belongsTo(PlayerProfile::class);
    }

    public function scopeStarters(Builder $query): Builder
    {
        return $query->where('slot_type', 'starter');
    }

    public function scopeSubstitutes(Builder $query): Builder
    {
        return $query->whereIn('slot_type', ['substitute', 'reserve']);
    }

    public function scopeByTeam(Builder $query, int $teamNumber): Builder
    {
        return $query->where('sub_team_number', $teamNumber);
    }
}
