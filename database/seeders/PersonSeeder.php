<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('persons')->count() == 0) {
            $persons = [
                [
                    'id' => 1,
                    'name' => 'Ash',
                    'lastname' => 'Ketchum',
                    'date_of_birth' => '1997-04-01',
                ],
                [
                    'id' => 2,
                    'name' => 'Delia',
                    'lastname' => 'Ketchum',
                    'date_of_birth' => '1970-01-01',
                ],
            ];

            DB::table('persons')->insert($persons);
        }
    }
}
