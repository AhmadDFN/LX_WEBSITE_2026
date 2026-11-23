<?php

namespace Database\Seeders;

use App\Models\GameMode;
use App\Models\PlayerProfile;
use App\Models\Squad;
use App\Models\SquadMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LuxuryEliteRosterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roster = [
            [
                'ign' => 'iRzell`LX',
                'delta_force_uid' => 'LX-001091',
                'preferred_class' => 'assault',
                'rank_tier' => 'Pinnacle',
                'status' => 'active',
                'player_type' => 'competitive',
                'role' => 'player',
                'discord_tag' => 'irzell#0001',
            ],
            [
                'ign' => 'SHADOW',
                'delta_force_uid' => 'LX-001092',
                'preferred_class' => 'recon',
                'rank_tier' => 'Pinnacle',
                'status' => 'active',
                'player_type' => 'competitive',
                'role' => 'player',
                'discord_tag' => 'shadow#0002',
            ],
            [
                'ign' => 'REAPER',
                'delta_force_uid' => 'LX-001093',
                'preferred_class' => 'support',
                'rank_tier' => 'Master',
                'status' => 'active',
                'player_type' => 'trial',
                'role' => 'player',
                'discord_tag' => 'reaper#0003',
            ],
            [
                'ign' => 'GHOST',
                'delta_force_uid' => 'LX-001094',
                'preferred_class' => 'engineer',
                'rank_tier' => 'Pinnacle',
                'status' => 'active',
                'player_type' => 'competitive',
                'role' => 'player',
                'discord_tag' => 'ghost#0004',
            ],
            [
                'ign' => 'VIPER',
                'delta_force_uid' => 'LX-001095',
                'preferred_class' => 'support',
                'rank_tier' => 'Master',
                'status' => 'active',
                'player_type' => 'competitive',
                'role' => 'player',
                'discord_tag' => 'viper#0005',
            ],
            [
                'ign' => 'BLAZE',
                'delta_force_uid' => 'LX-001096',
                'preferred_class' => 'assault',
                'rank_tier' => 'Diamond',
                'status' => 'active',
                'player_type' => 'trial',
                'role' => 'casual',
                'discord_tag' => 'blaze#0006',
            ],
            [
                'ign' => 'STORM',
                'delta_force_uid' => 'LX-001097',
                'preferred_class' => 'recon',
                'rank_tier' => 'Diamond',
                'status' => 'active',
                'player_type' => 'casual',
                'role' => 'casual',
                'discord_tag' => 'storm#0007',
            ],
        ];

        $createdProfiles = [];

        // 1. Seed dedicated demo users for testing
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@luxuryelite.web.id'],
            [
                'name' => 'HQ Superadmin',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );

        $coachUser = User::updateOrCreate(
            ['email' => 'coach@luxuryelite.web.id'],
            [
                'name' => 'Head Coach',
                'password' => Hash::make('password123'),
                'role' => 'coach',
                'is_active' => true,
            ]
        );

        foreach ($roster as $member) {
            $email = $member['ign'] === 'iRzell`LX' 
                ? 'irzell@luxuryelite.web.id' 
                : Str::slug(str_replace('`', '', $member['ign'])) . '@luxuryelite.web.id';

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $member['ign'],
                    'password' => Hash::make('password123'),
                    'role' => $member['role'],
                    'is_active' => true,
                ]
            );

            $profile = PlayerProfile::updateOrCreate(
                ['ign' => $member['ign']],
                [
                    'user_id' => $user->id,
                    'delta_force_uid' => $member['delta_force_uid'],
                    'player_type' => $member['player_type'],
                    'preferred_class' => $member['preferred_class'],
                    'rank_tier' => $member['rank_tier'],
                    'discord_tag' => $member['discord_tag'],
                    'status' => $member['status'],
                ]
            );

            $createdProfiles[$member['ign']] = $profile;
        }

        // Setup Havoc Warfare 20v20 hierarchy
        $havocMode = GameMode::where('slug', 'havoc-warfare')->first();

        if ($havocMode) {
            // 1. Seed Main Platoon (Warfare Battalion)
            $mainPlatoon = Squad::updateOrCreate(
                [
                    'game_mode_id' => $havocMode->id,
                    'squad_name' => 'LX Warfare Battalion',
                ],
                [
                    'parent_squad_id' => null,
                    'team_number' => null,
                    'captain_id' => $createdProfiles['iRzell`LX']->id ?? null,
                    'description' => 'Elite 20v20 Havoc Warfare Platoon divided into 5 tactical combat squads.',
                ]
            );

            // 2. Seed 5 Sub-Teams under Main Platoon
            $subTeams = [
                1 => [
                    'name' => 'LX Warfare - Team 1',
                    'desc' => 'Assault Squad (Frontline Spearhead & Breachers)',
                    'captain' => $createdProfiles['iRzell`LX']->id ?? null,
                ],
                2 => [
                    'name' => 'LX Warfare - Team 2',
                    'desc' => 'Armor & Vehicle Crew (Tanks, APCs, Mechanized Support)',
                    'captain' => $createdProfiles['GHOST']->id ?? null,
                ],
                3 => [
                    'name' => 'LX Warfare - Team 3',
                    'desc' => 'Tactical Support / Medic (Combat Healers & Supply Logistics)',
                    'captain' => $createdProfiles['VIPER']->id ?? null,
                ],
                4 => [
                    'name' => 'LX Warfare - Team 4',
                    'desc' => 'Recon & Flank (Precision Snipers, Drone Spotters & Flankers)',
                    'captain' => $createdProfiles['SHADOW']->id ?? null,
                ],
                5 => [
                    'name' => 'LX Warfare - Team 5',
                    'desc' => 'Objective Control (Zone Fortification & Counter-Offense)',
                    'captain' => $createdProfiles['REAPER']->id ?? null,
                ],
            ];

            $createdSubSquads = [];

            foreach ($subTeams as $teamNum => $teamData) {
                $subSquad = Squad::updateOrCreate(
                    [
                        'game_mode_id' => $havocMode->id,
                        'parent_squad_id' => $mainPlatoon->id,
                        'team_number' => $teamNum,
                    ],
                    [
                        'squad_name' => $teamData['name'],
                        'captain_id' => $teamData['captain'],
                        'description' => $teamData['desc'],
                    ]
                );

                $createdSubSquads[$teamNum] = $subSquad;
            }

            // 3. Assign Starter slots to Team 1–5 in Parent Platoon & Sub-Teams
            $startersMap = [
                'iRzell`LX' => ['team' => 1, 'role' => 'Frontline Breacher', 'squad' => $createdSubSquads[1]],
                'GHOST'     => ['team' => 2, 'role' => 'Armor Heavy Operator', 'squad' => $createdSubSquads[2]],
                'VIPER'     => ['team' => 3, 'role' => 'Chief Combat Medic', 'squad' => $createdSubSquads[3]],
                'SHADOW'    => ['team' => 4, 'role' => 'Forward Recon Marksman', 'squad' => $createdSubSquads[4]],
                'REAPER'    => ['team' => 5, 'role' => 'Anchor Fortification Specialist', 'squad' => $createdSubSquads[5]],
            ];

            foreach ($startersMap as $ign => $details) {
                if (isset($createdProfiles[$ign])) {
                    $profile = $createdProfiles[$ign];

                    // Register into Main Platoon as Starter for that specific Sub-Team
                    SquadMember::updateOrCreate(
                        [
                            'squad_id' => $mainPlatoon->id,
                            'player_profile_id' => $profile->id,
                        ],
                        [
                            'slot_type' => 'starter',
                            'sub_team_number' => $details['team'],
                            'role_specialization' => $details['role'],
                        ]
                    );

                    // Also link into Sub-Team squad as starter
                    SquadMember::updateOrCreate(
                        [
                            'squad_id' => $details['squad']->id,
                            'player_profile_id' => $profile->id,
                        ],
                        [
                            'slot_type' => 'starter',
                            'sub_team_number' => $details['team'],
                            'role_specialization' => $details['role'],
                        ]
                    );
                }
            }

            // 4. Populate the Substitute Pool in the Main Platoon (unlimited capacity)
            $substitutesMap = [
                'BLAZE' => ['sub_team' => null, 'role' => 'Infantry Flex Substitute', 'slot_type' => 'substitute'],
                'STORM' => ['sub_team' => null, 'role' => 'Recon Reserve Operator', 'slot_type' => 'reserve'],
            ];

            foreach ($substitutesMap as $ign => $details) {
                if (isset($createdProfiles[$ign])) {
                    $profile = $createdProfiles[$ign];

                    SquadMember::updateOrCreate(
                        [
                            'squad_id' => $mainPlatoon->id,
                            'player_profile_id' => $profile->id,
                        ],
                        [
                            'slot_type' => $details['slot_type'],
                            'sub_team_number' => $details['sub_team'],
                            'role_specialization' => $details['role'],
                        ]
                    );
                }
            }
        }
    }
}
