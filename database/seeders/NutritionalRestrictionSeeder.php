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
                'description' => 'vegetarian',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 2,
                'description' => 'vegan',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 3,
                'description' => 'celiac',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 4,
                'description' => 'keto',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 5,
                'description' => 'diabetic',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 6,
                'description' => 'lactose intolerant',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 7,
                'description' => 'gluten intolerant',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 8,
                'description' => 'hypertense',
            ]);
        }

        if (DB::table('nutritional_restrictions')->count() == 8) {
            DB::table('nutritional_restrictions')->insert([
                'id' => 9,
                'description' => 'dairy-free',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 10,
                'description' => 'wheat-free',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 11,
                'description' => 'nut-free',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 12,
                'description' => 'soy-free',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 13,
                'description' => 'egg-free',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 14,
                'description' => 'shellfish-free',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 15,
                'description' => 'fish-free',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 16,
                'description' => 'pork-free',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 17,
                'description' => 'red meat-free',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 18,
                'description' => 'caffeine-free',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 19,
                'description' => 'alcohol-free',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 20,
                'description' => 'spicy food-free',
            ]);

            DB::table('nutritional_restrictions')->insert([
                'id' => 21,
                'description' => 'peanut allergy',
            ]);
        }

        if (DB::table('nutritional_restrictions')->count() == 21) {
            DB::table('nutritional_restrictions')->insert([
                'id' => 22,
                'description' => 'pescetarian',
            ]);
        }
    }
}
