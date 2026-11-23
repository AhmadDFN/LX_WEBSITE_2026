<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GameModeSeeder::class,
            LuxuryEliteRosterSeeder::class,
            AdminUserSeeder::class,
            TournamentSeeder::class,
        ]);
    }
}
