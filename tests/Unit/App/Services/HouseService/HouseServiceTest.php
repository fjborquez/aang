<?php

namespace Tests\Unit\App\Services\HouseService;

use App\Models\House;
use App\Services\HouseService\HouseService;
use Exception;
use InvalidArgumentException;
use Mockery;
use stdClass;
use Tests\TestCase;

class HouseServiceTest extends TestCase
{
    private $mockedHouse;

    private $fakeHouseService;

    private $fakeHouseId;

    private $fakeHouse;

    public function setUp(): void
    {
        $this->mockedHouse = Mockery::mock(House::class);
        $this->fakeHouseService = new HouseService($this->mockedHouse);
        $this->fakeHouseId = 1;
        $this->fakeHouse = new House;
    }

    public function test_should_get_a_house_when_house_id_exists(): void
    {
        $this->mockedHouse->shouldReceive('find')->once()->andReturn($this->mockedHouse);
        $this->assertNotNull($this->fakeHouseService->get(1));
    }

    public function test_should_throw_an_exception_when_get_a_house_and_house_id_not_exists(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->mockedHouse->shouldReceive('find')->once()->andReturn(null);
        $this->fakeHouseService->get(-1);
    }

    public function test_should_enable_the_house_when_is_active_is_false()
    {
        $this->mockedHouse->shouldReceive('getAttribute')->with('is_active')->andReturn(false);
        $this->mockedHouse->shouldReceive('update')->andReturn(null);
        $this->mockedHouse->shouldReceive('find')->once()->andReturn($this->mockedHouse);
        $this->fakeHouseService->enable($this->fakeHouseId);
    }

    public function test_should_throw_exception_when_house_does_not_exist_when_enable()
    {
        $this->mockedHouse->shouldReceive('find')->andReturn(null);
        $this->expectException(Exception::class);
        $this->fakeHouseService->enable($this->fakeHouseId);
        $this->assertFalse($this->mockedHouse->is_active);
    }

    public function test_should_throw_exception_when_description_is_null(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The 'description' attribute is required and cannot be null.");
        $this->mockedHouse = new House;
        $this->fakeHouseService->create($this->mockedHouse);
    }

    public function test_should_throw_exception_when_description_is_empty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The 'description' attribute is required and cannot be empty.");
        $this->fakeHouse->description = '';
        $this->fakeHouseService = new HouseService($this->fakeHouse);
        $this->fakeHouseService->create($this->fakeHouse);
    }

    public function test_should_throw_exception_when_city_id_is_null(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The 'city_id' attribute is required and cannot be null.");

        $this->fakeHouse->description = 'description';
        $this->fakeHouseService->create($this->fakeHouse);
    }

    public function test_should_throw_exception_when_house_is_already_enabled()
    {
        $this->fakeHouse->is_active = true;
        $this->mockedHouse->shouldReceive('find')->andReturn($this->fakeHouse);
        $this->expectException(Exception::class);
        $this->fakeHouseService->enable($this->fakeHouseId);
    }

    public function test_should_disable_the_house_when_is_active_is_true()
    {
        $fakeHouse = Mockery::mock('House')->makePartial();
        $fakeHouse->pivot = new stdClass;
        $fakeHouse->pivot->is_default = false;
        $fakeHouse->is_active = true;
        $fakeHouse->persons = [];
        $fakeHouse->shouldReceive('update')->once()->andReturn(null);
        $this->mockedHouse->shouldReceive('find')->once()->andReturn($fakeHouse);
        $this->fakeHouseService->disable($this->fakeHouseId);
    }

    public function test_should_throw_exception_when_house_does_not_exist_when_disable()
    {
        $this->mockedHouse->shouldReceive('find')->andReturn(null);
        $this->expectException(Exception::class);
        $this->fakeHouseService->disable($this->fakeHouseId);
    }

    public function test_should_throw_exception_when_house_is_already_disabled()
    {
        $this->fakeHouse->is_active = false;
        $this->mockedHouse->shouldReceive('find')->andReturn($this->fakeHouse);
        $this->expectException(Exception::class);
        $this->fakeHouseService->disable($this->fakeHouseId);
    }

    public function test_should_throw_exception_when_disable_house_by_default()
    {
        $this->fakeHouse->pivot = new stdClass;
        $this->fakeHouse->pivot->is_default = true;
        $this->mockedHouse->shouldReceive('find')->andReturn($this->fakeHouse);
        $this->expectException(Exception::class);
        $this->fakeHouseService->disable($this->fakeHouseId);
    }
}
