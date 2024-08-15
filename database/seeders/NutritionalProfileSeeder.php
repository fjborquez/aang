<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NutritionalProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nutritional_profiles')->insert([
            ['person_id' => 1, 'nutritional_restriction_id' => 6],
            ['person_id' => 1, 'nutritional_restriction_id' => 7],
            ['person_id' => 1, 'nutritional_restriction_id' => 21],
            ['person_id' => 2, 'nutritional_restriction_id' => 1],
            ['person_id' => 2, 'nutritional_restriction_id' => 9],
            ['person_id' => 2, 'nutritional_restriction_id' => 19],
        ]);
    }
}
