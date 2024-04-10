<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NutritionalRestrictionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('nutritional_restrictions')->count() == 0) {
            DB::table('nutritional_restrictions')->insert([
                'id' => 1,
                'description' => 'vegetarian'
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 2,
                'description' => 'vegan'
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 3,
                'description' => 'celiac'
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 4,
                'description' => 'keto'
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 5,
                'description' => 'diabetic'
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 6,
                'description' => 'lactose intolerant'
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 7,
                'description' => 'gluten intolerant'
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 8,
                'description' => 'hypertense'
            ]);
        }
    }
}
