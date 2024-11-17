<?php

namespace Tests\Unit\App\Services\CityService;

use App\Services\CityService\CityService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class CityServiceTest extends TestCase
{
    private $mockedCity;

    private $cityService;

    private function generateMockedCities()
    {
        return new Collection([
            [
                'id' => 1,
                'description' => 'Arica',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'description' => 'Iquique',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'description' => 'Antofagasta',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'description' => 'Copiapó',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 5,
                'description' => 'La Serena',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 6,
                'description' => 'Valparaíso',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 7,
                'description' => 'Viña del Mar',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 8,
                'description' => 'Villa Alemana',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 9,
                'description' => 'Santiago',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 10,
                'description' => 'Rancagua',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 11,
                'description' => 'Talca',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 12,
                'description' => 'Chillán',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 13,
                'description' => 'Concepción',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 14,
                'description' => 'Temuco',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 15,
                'description' => 'Pucón',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 16,
                'description' => 'Valdivia',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 17,
                'description' => 'Puerto Montt',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 18,
                'description' => 'Puerto Varas',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 19,
                'description' => 'Frutillar',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 20,
                'description' => 'Osorno',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 21,
                'description' => 'Chiloé',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 22,
                'description' => 'Coyhaique',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 23,
                'description' => 'Puerto Aysén',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 24,
                'description' => 'Puerto Natales',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 25,
                'description' => 'Punta Arenas',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }

    public function setUp(): void
    {
        $this->mockedCity = Mockery::mock('overload:App\Models\City');
        $this->cityService = new CityService($this->mockedCity);
    }

    public function testGetListReturnsCorrectCitiesList(): void
    {
        $mockData = $this->generateMockedCities();

        $this->mockedCity->shouldReceive('all')->andReturn($mockData);
        $result = $this->cityService->getList();

        $this->assertEquals($mockData, $result);
    }
}
