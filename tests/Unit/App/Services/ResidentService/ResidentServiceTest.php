<?php

namespace Tests\Unit\App\Services\ResidentService;

use App\Models\Person;
use App\Services\ResidentService\ResidentService;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use stdClass;
use Tests\TestCase;

class ResidentServiceTest extends TestCase
{
    private $mockedPerson;

    private $mockedBuilder;

    private ResidentService $residentService;

    private int $fakePersonId;

    public function setUp(): void
    {
        $this->mockedPerson = Mockery::mock(Person::class);
        $this->mockedBuilder = Mockery::mock(Builder::class);
        $this->fakePersonId = 1;
        $this->residentService = new ResidentService($this->mockedPerson);
    }

    public function test_should_return_non_empty_list_when_house_exists()
    {
        $this->mockedBuilder->shouldReceive('get')->once()->andReturn(new Collection([new stdClass()]));
        $this->mockedPerson->shouldReceive('whereHas')->once()->andReturn($this->mockedBuilder);
        $list = $this->residentService->getList($this->fakePersonId);
        $this->assertFalse($list->isEmpty());
    }

    public function test_should_return_empty_list_when_house_does_not_exist()
    {
        $this->mockedBuilder->shouldReceive('get')->once()->andReturn(new Collection);
        $this->mockedPerson->shouldReceive('whereHas')->once()->andReturn($this->mockedBuilder);
        $list = $this->residentService->getList($this->fakePersonId);
        $this->assertTrue($list->isEmpty());
    }
}
