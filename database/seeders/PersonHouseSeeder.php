<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('persons_houses')->count() == 0) {
            $personsHouses = [
                [
                    'person_id' => 1,
                    'house_id' => 1,
                    'house_role_id' => 1,
                    'is_default' => true,
                ],
                [
                    'person_id' => 2,
                    'house_id' => 1,
                    'house_role_id' => 2,
                    'is_default' => true,
                ],
            ];

            DB::table('persons_houses')->insert($personsHouses);
        }
    }
}
