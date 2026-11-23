<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlayerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ign',
        'delta_force_uid',
        'player_type',
        'preferred_class',
        'rank_tier',
        'discord_tag',
        'avatar_url',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function squads(): BelongsToMany
    {
        return $this->belongsToMany(Squad::class, 'squad_members')
            ->using(SquadMember::class)
            ->withPivot(['id', 'slot_type', 'sub_team_number', 'role_specialization'])
            ->withTimestamps();
    }

    public function squadMembers(): HasMany
    {
        return $this->hasMany(SquadMember::class);
    }

    public function scrimAttendances(): HasMany
    {
        return $this->hasMany(ScrimAttendance::class);
    }

    public function mvpMatches(): HasMany
    {
        return $this->hasMany(MatchResult::class, 'mvp_player_id');
    }

    public function scopeCompetitive(Builder $query): Builder
    {
        return $query->where('player_type', 'competitive');
    }

    public function scopeCasual(Builder $query): Builder
    {
        return $query->where('player_type', 'casual');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }
}
