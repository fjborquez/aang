<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HouseRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('house_roles')->count() == 0) {
            $houseRoles = [
                [
                    'id' => 1,
                    'name' => 'Host',
                ],
                [
                    'id' => 2,
                    'name' => 'Resident',
                ],
                [
                    'id' => 3,
                    'name' => 'Guest',
                ],
            ];

            DB::table('house_roles')->insert($houseRoles);
        }
    }
}
