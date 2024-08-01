<?php

namespace Tests\Unit\App\Services\ResidentService;

use App\Exceptions\ResourceNotFoundException;
use App\Models\House;
use App\Models\Person;
use App\Models\User;
use App\Services\ResidentService\ResidentService;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Mockery;
use stdClass;
use Tests\TestCase;

class ResidentServiceTest extends TestCase
{
    private $mockedPerson;

    private $mockedHouse;

    private $mockedBuilder;

    private ResidentService $residentService;

    private int $fakePersonId;

    public function setUp(): void
    {
        $this->mockedPerson = Mockery::mock(Person::class);
        $this->mockedHouse = Mockery::mock(House::class);
        $this->mockedBuilder = Mockery::mock(Builder::class);
        $this->fakePersonId = 1;
        $this->residentService = new ResidentService($this->mockedPerson, $this->mockedHouse);
    }

    public function test_should_return_non_empty_list_when_house_exists()
    {
        $this->mockedBuilder->shouldReceive('get')->once()->andReturn(new Collection([new stdClass]));
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

    public function test_should_delete_a_resident_when_resident_is_an_user()
    {
        $belongsToMany = Mockery::mock(BelongsToMany::class);
        $belongsToMany->shouldReceive('get')->twice()->andReturn(new Collection(new House));
        $belongsToMany->shouldReceive('sync')->once()->andReturnSelf();
        $belongsToManyPersons = Mockery::mock(BelongsToMany::class)->makePartial();
        $belongsToManyPersons->shouldReceive('contains')->andReturn(true);
        $person = new Person();
        $person->id = 1;
        $personCollection = new Collection();
        $personCollection->add($person);
        $this->mockedHouse->shouldReceive('with')->with('persons')->andReturn($this->mockedHouse);
        $this->mockedHouse->shouldReceive('find')->once()->andReturn($this->mockedHouse);
        $this->mockedHouse->shouldReceive('persons')->andReturn($belongsToManyPersons);
        $this->mockedHouse->shouldReceive('getAttribute')->with('persons')->andReturn($personCollection);
        $this->mockedPerson->shouldReceive('with')->with('houses')->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('with')->with('user')->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('find')->once()->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('houses')->times(3)->andReturn($belongsToMany);
        $this->mockedPerson->shouldReceive('getAttribute')->once()->with('user')->andReturn(new User);
        $this->residentService->delete(1, 1);
        $this->assertEquals(0, $this->mockedPerson->houses()->get()->count());
    }

    public function test_should_delete_a_resident_when_resident_belongs_to_other_house()
    {
        $house1 = new House;
        $house2 = new House;
        $house1->id = 1;
        $house2->id = 2;
        $person = new Person();
        $person->id = 1;
        $personCollection = new Collection();
        $personCollection->add($person);
        $belongsToMany = Mockery::mock(BelongsToMany::class);
        $belongsToMany->shouldReceive('get')->twice()->andReturn(new Collection($house1, $house2));
        $belongsToMany->shouldReceive('sync')->once()->andReturnSelf();
        $belongsToManyPersons = Mockery::mock(BelongsToMany::class)->makePartial();
        $belongsToManyPersons->shouldReceive('contains')->andReturn(true);
        $this->mockedHouse->shouldReceive('with')->with('persons')->andReturn($this->mockedHouse);
        $this->mockedHouse->shouldReceive('find')->once()->andReturn($this->mockedHouse);
        $this->mockedHouse->shouldReceive('persons')->andReturn($belongsToManyPersons);
        $this->mockedHouse->shouldReceive('getAttribute')->with('persons')->andReturn($personCollection);
        $this->mockedPerson->shouldReceive('with')->with('houses')->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('with')->with('user')->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('find')->once()->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('houses')->times(3)->andReturn($belongsToMany);
        $this->mockedPerson->shouldReceive('getAttribute')->once()->with('user')->andReturn(new User);
        $this->residentService->delete(1, 1);
        $this->assertEquals(1, $this->mockedPerson->houses()->get()->count());
    }

    public function test_should_delete_a_resident_when_is_not_an_user_and_not_belongs_to_other_house()
    {
        $belongsToManyPersons = Mockery::mock(BelongsToMany::class)->makePartial();
        $belongsToManyPersons->shouldReceive('contains')->andReturn(true);
        $person = new Person();
        $person->id = 2;
        $personCollection = new Collection();
        $personCollection->add($person);
        $this->mockedHouse->shouldReceive('with')->with('persons')->andReturn($this->mockedHouse);
        $this->mockedHouse->shouldReceive('find')->once()->andReturn($this->mockedHouse);
        $this->mockedHouse->shouldReceive('persons')->andReturn($belongsToManyPersons);
        $this->mockedHouse->shouldReceive('getAttribute')->with('persons')->andReturn($personCollection);
        $this->mockedPerson->shouldReceive('with')->with('houses')->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('with')->with('user')->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('find')->once()->andReturn($this->mockedPerson);
        $this->expectException(ResourceNotFoundException::class);
        $this->residentService->delete(1, 1);
    }

    public function test_should_not_delete_a_resident_when_resident_does_not_belong_to_house()
    {
        $house1 = new House;
        $house2 = new House;
        $house1->id = 1;
        $house2->id = 2;
        $belongsToManyPersons = Mockery::mock(BelongsToMany::class)->makePartial();
        $belongsToManyPersons->shouldReceive('contains')->andReturn(true);
        $belongsToMany = Mockery::mock(BelongsToMany::class)->makePartial();
        $belongsToMany->shouldReceive('get')->andReturn(new Collection($house1, $house2));
        $belongsToMany->shouldReceive('sync')->andReturnSelf();
        $person = new Person();
        $person->id = 1;
        $personCollection = new Collection();
        $personCollection->add($person);
        $this->mockedHouse->shouldReceive('with')->with('persons')->andReturn($this->mockedHouse);
        $this->mockedHouse->shouldReceive('find')->once()->andReturn($this->mockedHouse);
        $this->mockedHouse->shouldReceive('persons')->andReturn($belongsToManyPersons);
        $this->mockedHouse->shouldReceive('getAttribute')->with('persons')->andReturn($personCollection);
        $this->mockedPerson->shouldReceive('with')->with('houses')->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('with')->with('user')->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('find')->once()->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('getAttribute')->once()->with('user')->andReturn(new User);
        $this->mockedPerson->shouldReceive('houses')->andReturn($belongsToMany);
        $this->mockedPerson->shouldReceive('getAttribute')->with('houses')->andReturn(new Collection($house1, $house2));
        $this->residentService->delete(1, 1);
        $this->assertEquals(1, $this->mockedPerson->houses->count());
    }

    public function test_should_throws_an_exception_when_house_is_not_found()
    {
        $this->mockedHouse->shouldReceive('with')->with('persons')->andReturn($this->mockedHouse);
        $this->mockedHouse->shouldReceive('find')->once()->andReturn(null);
        $this->expectException(ResourceNotFoundException::class);
        $this->residentService->delete(1, 1);

    }

    public function test_should_throws_an_exception_when_resident_is_not_found()
    {
        $this->mockedHouse->shouldReceive('with')->with('persons')->andReturn($this->mockedHouse);
        $this->mockedHouse->shouldReceive('find')->once()->andReturn($this->mockedHouse);
        $this->mockedPerson->shouldReceive('with')->with('houses')->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('with')->with('user')->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('find')->once()->andReturn(null);
        $this->expectException(ResourceNotFoundException::class);
        $this->residentService->delete(1, 1);
    }
}
