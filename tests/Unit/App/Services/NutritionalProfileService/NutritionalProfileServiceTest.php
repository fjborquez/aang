<?php

use App\Exceptions\ResourceNotFoundException;
use App\Models\Person;
use App\Services\NutritionalProfileService\NutritionalProfileService;
use App\Services\PersonService\PersonService;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class NutritionalProfileServiceTest extends TestCase
{
    private $mockedPersonService;

    private $nutritionalProfileService;

    private $mockedPerson;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockedPerson = Mockery::mock(Person::class);
        $this->mockedPersonService = Mockery::mock(PersonService::class);
        $this->nutritionalProfileService = new NutritionalProfileService($this->mockedPersonService);
    }

    public function test_should_not_create_a_profile_when_data_is_empty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Nutritional profile data cannot be empty');
        $this->nutritionalProfileService->create(1, []);
    }

    public function test_should_not_create_a_profile_when_data_is_null(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Nutritional profile data cannot be empty');
        $this->nutritionalProfileService->create(1);
    }

    public function test_should_not_create_a_profile_when_person_id_is_incorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid person id');
        $this->nutritionalProfileService->create(0, ['product_category_id' => 1, 'product_category_name' => 'Bakery', 'consumption_level_id' => 5]);
    }

    public function test_should_not_create_a_profile_when_consumption_level_is_null()
    {
        $data = [
            [
                'product_category_id' => 9,
                'product_category_name' => 'Vegetables',
                'consumption_level_id' => null,
            ],
        ];

        $personId = 1;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Consumption level is invalid');
        $this->nutritionalProfileService->create($personId, $data);
    }

    public function test_should_not_create_a_profile_when_consumption_level_is_empty()
    {
        $data = [
            [
                'product_category_id' => 9,
                'product_category_name' => 'Vegetables',
                'consumption_level_id' => '',
            ],
        ];

        $personId = 1;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Consumption level is invalid');
        $this->nutritionalProfileService->create($personId, $data);
    }

    public function test_should_not_create_a_profile_when_consumption_level_is_invalid()
    {
        $data = [
            [
                'product_category_id' => 9,
                'product_category_name' => 'Vegetables',
                'consumption_level_id' => -1,
            ],
        ];

        $personId = 1;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Consumption level is invalid');
        $this->nutritionalProfileService->create($personId, $data);
    }

    public function test_create_nutritional_profiles()
    {
        $data = [
            [
                'product_category_id' => 9,
                'product_category_name' => 'Vegetables',
                'consumption_level_id' => 3,
            ],
            [
                'product_category_id' => 8,
                'product_category_name' => 'Fruits',
                'consumption_level_id' => 2,
            ],
        ];

        $personId = 1;
        $mock = Mockery::mock('overload:App\Models\NutritionalProfile');
        $mock->shouldReceive('save')->once()->andReturn(true);
        $this->nutritionalProfileService->create($personId, $data);
    }

    public function test_should_get_a_profile_when_person_exists(): void
    {
        $this->mockedPerson = $this->createMock(Person::class);
        $this->mockedPerson->method('__get')->with('nutritionalProfile')->willReturn(new Collection([]));
        $this->mockedPersonService->shouldReceive('get')->once()->andReturn($this->mockedPerson);
        $profile = $this->nutritionalProfileService->get(1);
        assertEquals([], $profile);
    }

    public function test_should_update_when_person_exists(): void
    {
        $data = [
            [
                'product_category_id' => 9,
                'product_category_name' => 'Vegetables',
                'consumption_level_id' => 3,
            ],
            [
                'product_category_id' => 8,
                'product_category_name' => 'Fruits',
                'consumption_level_id' => 2,
            ],
        ];
        $mock = Mockery::mock('overload:App\Models\NutritionalProfile');
        $mock->shouldReceive('where')->andReturn($mock);
        $mock->shouldReceive('first')->andReturn($mock);
        $mock->shouldReceive('save')->once()->andReturn(true);

        $this->nutritionalProfileService->update(1, $data);
    }

    public function test_should_delete_when_nutritional_profile_exists()
    {
        $mock = Mockery::mock('overload:App\Models\NutritionalProfile');
        $mock->shouldReceive('where')->andReturn($mock);
        $mock->shouldReceive('first')->andReturn($mock);
        $mock->shouldReceive('delete')->once()->andReturn(true);
        $this->nutritionalProfileService->delete(1, 1);
    }

    public function test_should_not_delete_when_nutritional_profile_does_not_exist()
    {
        $mock = Mockery::mock('overload:App\Models\NutritionalProfile');
        $mock->shouldReceive('where')->andReturn($mock);
        $mock->shouldReceive('first')->andReturn(null);
        $this->expectException(ResourceNotFoundException::class);
        $this->nutritionalProfileService->delete(1, 1);
    }
}
