<?php

namespace Tests\Unit\App\Services\HouseService;

use App\Models\House;
use App\Services\HouseService\HouseService;
use Exception;
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
        $this->fakeHouse = new House();
    }

    public function test_should_enable_the_house_when_is_active_is_false()
    {
        $this->fakeHouse->is_active = false;
        $this->mockedHouse->shouldReceive('find')->once()->andReturn($this->fakeHouse);
        $this->fakeHouseService->enable($this->fakeHouseId);
    }

    public function test_should_throw_exception_when_house_does_not_exist_when_enable()
    {
        $this->mockedHouse->shouldReceive('find')->once()->andReturn(null);
        $this->expectException(Exception::class);
        $this->fakeHouseService->enable($this->fakeHouseId);
    }

    public function test_should_throw_exception_when_house_is_already_enabled()
    {
        $this->fakeHouse->is_active = true;
        $this->mockedHouse->shouldReceive('find')->once()->andReturn($this->fakeHouse);
        $this->expectException(Exception::class);
        $this->fakeHouseService->enable($this->fakeHouseId);
    }

    public function test_should_disable_the_house_when_is_active_is_true()
    {
        $this->fakeHouse->pivot = new stdClass();
        $this->fakeHouse->pivot->is_default = false;
        $this->fakeHouse->is_active = true;
        $this->mockedHouse->shouldReceive('find')->once()->andReturn($this->fakeHouse);
        $this->fakeHouseService->disable($this->fakeHouseId);
    }

    public function test_should_throw_exception_when_house_does_not_exist_when_disable()
    {
        $this->mockedHouse->shouldReceive('find')->once()->andReturn(null);
        $this->expectException(Exception::class);
        $this->fakeHouseService->disable($this->fakeHouseId);
    }

    public function test_should_throw_exception_when_house_is_already_disabled()
    {
        $this->fakeHouse->is_active = false;
        $this->mockedHouse->shouldReceive('find')->once()->andReturn($this->fakeHouse);
        $this->expectException(Exception::class);
        $this->fakeHouseService->disable($this->fakeHouseId);
    }

    public function test_should_throw_exception_when_disable_house_by_default()
    {
        $this->fakeHouse->pivot = new stdClass();
        $this->fakeHouse->pivot->is_default = true;
        $this->mockedHouse->shouldReceive('find')->once()->andReturn($this->fakeHouse);
        $this->expectException(Exception::class);
        $this->fakeHouseService->disable($this->fakeHouseId);
    }
}
