<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameMode extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'team_size',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'team_size' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function squads(): HasMany
    {
        return $this->hasMany(Squad::class);
    }

    public function scrimMatches(): HasMany
    {
        return $this->hasMany(ScrimMatch::class);
    }

    public function recruitmentApplications(): HasMany
    {
        return $this->hasMany(RecruitmentApplication::class, 'target_game_mode_id');
    }
}
