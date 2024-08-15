<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('cities')->count() == 0) {
            DB::table('cities')->insert([
                ['id' => 1, 'description' => 'Arica'],
                ['id' => 2, 'description' => 'Iquique'],
                ['id' => 3, 'description' => 'Antofagasta'],
                ['id' => 4, 'description' => 'Copiapó'],
                ['id' => 5, 'description' => 'La Serena'],
                ['id' => 6, 'description' => 'Valparaíso'],
                ['id' => 7, 'description' => 'Viña del Mar'],
                ['id' => 8, 'description' => 'Villa Alemana'],
                ['id' => 9, 'description' => 'Santiago'],
                ['id' => 10, 'description' => 'Rancagua'],
                ['id' => 11, 'description' => 'Talca'],
                ['id' => 12, 'description' => 'Chillán'],
                ['id' => 13, 'description' => 'Concepción'],
                ['id' => 14, 'description' => 'Temuco'],
                ['id' => 15, 'description' => 'Pucón'],
                ['id' => 16, 'description' => 'Valdivia'],
                ['id' => 17, 'description' => 'Puerto Montt'],
                ['id' => 18, 'description' => 'Puerto Varas'],
                ['id' => 19, 'description' => 'Frutillar'],
                ['id' => 20, 'description' => 'Osorno'],
                ['id' => 21, 'description' => 'Chiloé'],
                ['id' => 22, 'description' => 'Coyhaique'],
                ['id' => 23, 'description' => 'Puerto Aysén'],
                ['id' => 24, 'description' => 'Puerto Natales'],
                ['id' => 25, 'description' => 'Punta Arenas'],
            ]);
        }
    }
}
