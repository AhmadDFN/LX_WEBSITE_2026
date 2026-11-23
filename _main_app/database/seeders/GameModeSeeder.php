<?php

namespace Database\Seeders;

use App\Models\GameMode;
use Illuminate\Database\Seeder;

class GameModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modes = [
            [
                'name' => 'Detonation',
                'slug' => 'detonation',
                'team_size' => 5,
                'description' => 'Competitive 5v5 Search & Destroy. Attackers plant the bomb, Defenders defuse or eliminate.',
                'is_active' => true,
            ],
            [
                'name' => 'Hazard Operations',
                'slug' => 'hazard-operations',
                'team_size' => 3,
                'description' => 'High-stakes 3v3 Tactical Extraction raid. Squad survival, secure Tekniq loot and MandelBrick.',
                'is_active' => true,
            ],
            [
                'name' => 'Havoc Warfare',
                'slug' => 'havoc-warfare',
                'team_size' => 20,
                'description' => '20v20 Combined Arms mega-map conquest. 5 sub-teams (Assault, Armor/Vehicle, Support/Medic, Recon, Objective Control) plus unlimited substitute pool.',
                'is_active' => true,
            ],
        ];

        foreach ($modes as $mode) {
            GameMode::updateOrCreate(
                ['slug' => $mode['slug']],
                $mode
            );
        }
    }
}
