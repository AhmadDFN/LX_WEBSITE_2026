<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Squad extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_mode_id',
        'parent_squad_id',
        'team_number',
        'squad_name',
        'captain_id',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'team_number' => 'integer',
        ];
    }

    public function gameMode(): BelongsTo
    {
        return $this->belongsTo(GameMode::class);
    }

    public function parentSquad(): BelongsTo
    {
        return $this->belongsTo(Squad::class, 'parent_squad_id');
    }

    public function subTeams(): HasMany
    {
        return $this->hasMany(Squad::class, 'parent_squad_id');
    }

    public function captain(): BelongsTo
    {
        return $this->belongsTo(PlayerProfile::class, 'captain_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(PlayerProfile::class, 'squad_members')
            ->using(SquadMember::class)
            ->withPivot(['id', 'slot_type', 'sub_team_number', 'role_specialization'])
            ->withTimestamps();
    }

    public function squadMembers(): HasMany
    {
        return $this->hasMany(SquadMember::class);
    }

    public function scrimMatches(): HasMany
    {
        return $this->hasMany(ScrimMatch::class);
    }

    public function scopePlatoons(Builder $query): Builder
    {
        return $query->whereNull('parent_squad_id');
    }

    public function scopeSubTeams(Builder $query): Builder
    {
        return $query->whereNotNull('parent_squad_id');
    }

    public function getStartersAttribute(): Collection
    {
        return $this->members()->wherePivot('slot_type', 'starter')->get();
    }

    public function getSubstitutesAttribute(): Collection
    {
        return $this->members()->wherePivotIn('slot_type', ['substitute', 'reserve'])->get();
    }
}
