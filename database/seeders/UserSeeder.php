<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('users')->count() == 0) {
            DB::table('users')->insert([
                'id' => 1,
                'email' => 'ash.ketchum@pokemon.com',
                'password' => Hash::make('ash.ketchum'),
                'person_id' => 1,
            ]);
        }
    }
}
