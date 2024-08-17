<?php

namespace Database\Seeders;

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
            ['person_id' => 1, 'product_category_id' => 1, 'consumption_level_id' => 1, 'product_category_name' => ''],
            ['person_id' => 1, 'product_category_id' => 2, 'consumption_level_id' => 2, 'product_category_name' => ''],
            ['person_id' => 1, 'product_category_id' => 3, 'consumption_level_id' => 3, 'product_category_name' => ''],
            ['person_id' => 2, 'product_category_id' => 4, 'consumption_level_id' => 4, 'product_category_name' => ''],
            ['person_id' => 2, 'product_category_id' => 5, 'consumption_level_id' => 5, 'product_category_name' => ''],
            ['person_id' => 2, 'product_category_id' => 6, 'consumption_level_id' => 1, 'product_category_name' => ''],
        ]);
    }
}
