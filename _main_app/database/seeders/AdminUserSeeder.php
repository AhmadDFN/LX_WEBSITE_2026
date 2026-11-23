<?php

namespace Database\Seeders;

use App\Models\PlayerProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Superadmin (Founder / Clan Owner)
        $owner = User::updateOrCreate(
            ['email' => 'admin@luxuryelite.web.id'],
            [
                'name' => 'Luxury Elite Command',
                'password' => Hash::make('luxury2026!'),
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );

        // 2. Clan Manager (Operations & Sparring)
        $manager = User::updateOrCreate(
            ['email' => 'manager@luxuryelite.web.id'],
            [
                'name' => 'LX Ops Manager',
                'password' => Hash::make('luxury2026!'),
                'role' => 'manager',
                'is_active' => true,
            ]
        );

        // 3. Head Coach (Tactics & Analytics)
        $coach = User::updateOrCreate(
            ['email' => 'coach@luxuryelite.web.id'],
            [
                'name' => 'LX Tactical Coach',
                'password' => Hash::make('luxury2026!'),
                'role' => 'coach',
                'is_active' => true,
            ]
        );

        // Ensure iRzell is superadmin / captain if user exists
        $irzell = User::where('name', 'like', '%iRzell%')->first();
        if ($irzell) {
            $irzell->update(['role' => 'superadmin']);
        }
    }
}
