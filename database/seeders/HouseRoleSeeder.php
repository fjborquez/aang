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
            DB::table('house_roles')->insert([
                'id' => 1,
                'name' => 'Host',
                'description' => '',
            ]);
            DB::table('house_roles')->insert([
                'id' => 2,
                'name' => 'Resident',
                'description' => '',
            ]);
            DB::table('house_roles')->insert([
                'id' => 3,
                'name' => 'Guest',
                'description' => '',
            ]);
        }
    }
}
