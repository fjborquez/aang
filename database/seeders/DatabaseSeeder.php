<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(NutritionalRestrictionSeeder::class);
        $this->call(HouseRoleSeeder::class);
        $this->call(ConsumptionLevelSeeder::class);
        $this->call(PersonSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(HouseSeeder::class);
        $this->call(PersonHouseSeeder::class);
        $this->call(NutritionalProfileSeeder::class);
    }
}
