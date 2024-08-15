<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsumptionLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('consumption_levels')->count() == 0) {
            $consumptionLevels = [
                [
                    'id' => 1,
                    'value' => 0,
                    'name' => 'Null',
                    'description' => 'This level indicates that the person should not consume products from this category under any circumstances due to their nutritional restriction.',
                ],
                [
                    'id' => 2,
                    'value' => 1,
                    'name' => 'Very Low',
                    'description' => 'Extremely limited consumption; almost never consumed. Only occasionally and in very small amounts.',
                ],
                [
                    'id' => 3,
                    'value' => 2,
                    'name' => 'Low',
                    'description' => 'Reduced consumption; can be consumed occasionally but always in small quantities and with caution.',
                ],
                [
                    'id' => 4,
                    'value' => 3,
                    'name' => 'Moderate',
                    'description' => 'Moderate consumption; allowed with some frequency, but not recommended in large quantities.',
                ],
                [
                    'id' => 5,
                    'value' => 4,
                    'name' => 'High',
                    'description' => 'Regular consumption; can be consumed often and in typical amounts without significant issues.',
                ],
                [
                    'id' => 6,
                    'value' => 5,
                    'name' => 'Very High',
                    'description' => 'Free consumption; the person can consume products from this category without any restriction.',
                ],
            ];

            DB::table('consumption_levels')->insert($consumptionLevels);
        }
    }
}
