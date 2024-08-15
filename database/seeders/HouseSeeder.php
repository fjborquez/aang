<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('houses')->count() == 0) {
            DB::table('houses')->insert([
                'id' => 1,
                'description' => 'Pallet Town',
                'city_id' => 1,
            ]);
        }
    }
}
