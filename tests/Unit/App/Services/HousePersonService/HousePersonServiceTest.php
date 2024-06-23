<?php

namespace Tests\Unit;

use App\HouseRole;
use App\Models\City;
use App\Models\House;
use App\Models\Person;
use App\Services\HousePersonService\HousePersonService;
use App\Services\HouseService\HouseService;
use App\Services\PersonService\PersonService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class HousePersonServiceTest extends TestCase
{
    private $mockedHousePersonService;

    private $mockedHouseService;

    private $mockedPersonService;

    private $personIdPayload;

    private $housesPayload;

    private $fakePerson;

    private $fakePersonHouses;

    private $fakeBelongsToMany;

    private $fakeHouse1;

    private $fakeHouse2;

    private $fakeHouse3;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockedHouseService = Mockery::mock(HouseService::class);
        $this->mockedPersonService = Mockery::mock(PersonService::class);
        $this->mockedHousePersonService = new HousePersonService($this->mockedHouseService, $this->mockedPersonService);

        $this->personIdPayload = 1;
        $this->housesPayload = [
            1 => [
                'is_default' => false,
                'house_role_id' => HouseRole::HOST->value,
            ],
            2 => [
                'is_default' => true,
                'house_role_id' => HouseRole::HOST->value,
            ],
            3 => [
                'is_default' => false,
                'house_role_id' => HouseRole::HOST->value,
            ],
        ];

        $this->fakePerson = Mockery::mock(Person::class);
        $this->fakeBelongsToMany = Mockery::mock(BelongsToMany::class);
        $fakeHouse1 = new House();
        $fakeHouse1->id = 1;
        $fakeHouse1->description = 'House 11';
        $fakeHouse1->city_id = 1;
        $fakeHouse2 = new House();
        $fakeHouse2->id = 2;
        $fakeHouse2->description = 'House 12';
        $fakeHouse2->city_id = 2;
        $fakeHouse3 = new House();
        $fakeHouse3->id = 3;
        $fakeHouse3->description = 'House 13';
        $fakeHouse3->city_id = 3;
        $this->fakePersonHouses = new Collection([
            $fakeHouse1,
            $fakeHouse2,
            $fakeHouse3,
        ]);

        $this->fakeHouse1 = new House();
        $this->fakeHouse1->id = 1;
        $this->fakeHouse1->description = 'House 21';
        $this->fakeHouse1->city_id = 1;
        $this->fakeHouse2 = new House();
        $this->fakeHouse2->id = 2;
        $this->fakeHouse2->description = 'House 22';
        $this->fakeHouse2->city_id = 2;
        $this->fakeHouse3 = new House();
        $this->fakeHouse3->id = 3;
        $this->fakeHouse3->description = 'House 23';
        $this->fakeHouse3->city_id = 3;
    }

    public function test_should_create_from_house_when_there_are_persons_to_be_added(): void
    {
        $fakeHouseId = 1;
        $fakePersons = [
            '1' => [
                'is_default' => false,
            ],
            '2' => [
                'is_default' => false,
            ],
        ];

        $this->fakeBelongsToMany->shouldReceive('count')->andReturn(0);
        $this->fakeBelongsToMany->shouldReceive('sync')->andReturn(null);
        $this->fakePerson->shouldReceive('houses')->andReturn($this->fakeBelongsToMany);
        $fakeHouse = Mockery::mock(House::class)->makePartial();
        $fakeHouse->shouldReceive('persons')->andReturn($this->fakeBelongsToMany);
        $this->mockedPersonService->shouldReceive('get')->andReturn($this->fakePerson);
        $this->mockedHouseService->shouldReceive('get')->once()->andReturn($fakeHouse);
        $this->mockedHousePersonService->createFromHouse($fakeHouseId, $fakePersons);

        $this->expectNotToPerformAssertions();
    }

    public function test_should_create_from_house_when_there_are_persons_with_houses(): void
    {
        $fakeHouseId = 1;
        $fakePersons = [
            '1' => [
                'is_default' => true,
            ],
            '2' => [
                'is_default' => false,
            ],
        ];

        $this->fakeBelongsToMany->shouldReceive('count')->andReturn(0, 1);
        $this->fakeBelongsToMany->shouldReceive('sync')->once()->andReturn(null);
        $this->fakeBelongsToMany->shouldReceive('get')->andReturn(new Collection());
        $this->fakePerson->shouldReceive('houses')->andReturn($this->fakeBelongsToMany);
        $fakeHouse = Mockery::mock(House::class)->makePartial();
        $fakeHouse->shouldReceive('persons')->andReturn($this->fakeBelongsToMany);
        $this->mockedPersonService->shouldReceive('get')->andReturn($this->fakePerson);
        $this->mockedHouseService->shouldReceive('get')->once()->andReturn($fakeHouse);
        $this->mockedHousePersonService->createFromHouse($fakeHouseId, $fakePersons);

        $this->expectNotToPerformAssertions();
    }

    public function test_should_create_from_house_when_house_have_no_persons(): void
    {
        $fakeHouseId = 1;
        $fakePersons = [
            '1' => [
                'is_default' => false,
            ],
            '2' => [
                'is_default' => false,
            ],
        ];

        $fakeHouse = Mockery::mock(House::class)->makePartial();
        $fakeHouse->shouldReceive('persons')->andReturn($this->fakeBelongsToMany);
        $this->mockedHouseService->shouldReceive('get')->andReturn($fakeHouse);
        $this->fakeBelongsToMany->shouldReceive('count')->andReturn(1);
        $this->expectException(Exception::class);
        $this->mockedHousePersonService->createFromHouse($fakeHouseId, $fakePersons);
    }

    public function test_should_create_from_person_when_there_are_houses_to_be_added(): void
    {
        $fakePersonId = 1;
        $fakeHouses = [
            '1' => [
                'house_role_id' => HouseRole::HOST->value,
                'is_default' => true
            ],
            '2' => [
                'house_role_id' => HouseRole::HOST->value,
                'is_default' => false
            ],
        ];
        $fakePerson = Mockery::mock(Person::class);

        $this->fakeBelongsToMany->shouldReceive('sync')->once()->andReturn(null);
        $this->fakeBelongsToMany->shouldReceive('get')->andReturn(new Collection());
        $this->fakeBelongsToMany->shouldReceive('count')->andReturn(0);
        $fakePerson->shouldReceive('houses')->andReturn($this->fakeBelongsToMany);
        $this->mockedHouseService->shouldReceive('get')->andReturn($this->fakeHouse1, $this->fakeHouse2, $this->fakeHouse3);
        $this->mockedPersonService->shouldReceive('get')->andReturn($fakePerson);

        $this->mockedHousePersonService->createFromPerson($fakePersonId, $fakeHouses);

        $this->expectNotToPerformAssertions();
    }

    public function test_should_throw_exception_when_create_from_person_with_same_houses(): void
    {
        $fakePersonId = 1;
        $fakeHouses = [
            '1' => [
                'house_role_id' => HouseRole::HOST->value,
            ],
            '2' => [
                'house_role_id' => HouseRole::HOST->value
            ],
        ];
        $fakePerson = Mockery::mock(Person::class);
        $this->fakeHouse1->city_id = 1;
        $this->fakeHouse2->city_id = 1;
        $this->fakeHouse2->description = 'House 21';

        $this->fakeBelongsToMany->shouldReceive('sync')->andReturn(null);
        $this->fakeBelongsToMany->shouldReceive('get')->andReturn(new Collection());
        $this->fakeBelongsToMany->shouldReceive('count')->andReturn(0);
        $fakePerson->shouldReceive('houses')->andReturn($this->fakeBelongsToMany);
        $this->mockedHouseService->shouldReceive('get')->andReturn($this->fakeHouse1, $this->fakeHouse2, $this->fakeHouse3);
        $this->mockedPersonService->shouldReceive('get')->andReturn($fakePerson);

        $this->expectException(Exception::class);
        $this->mockedHousePersonService->createFromPerson($fakePersonId, $fakeHouses);
    }

    public function test_update_from_person_successfully(): void
    {
        $this->mockedPersonService->shouldReceive('get')->once()->andReturn($this->fakePerson);
        $this->mockedHouseService->shouldReceive('get')->andReturn($this->fakeHouse1, $this->fakeHouse2, $this->fakeHouse3);
        $this->fakePerson->shouldReceive('houses')->andReturn($this->fakeBelongsToMany);
        $this->fakeBelongsToMany->shouldReceive('sync')->andReturnSelf();
        $this->fakeBelongsToMany->shouldReceive('get')->andReturn($this->fakePersonHouses);
        $this->fakeBelongsToMany->shouldReceive('updateExistingPivot')->andReturn();

        $this->mockedHousePersonService->updateFromPerson($this->personIdPayload, $this->housesPayload);

        $this->expectNotToPerformAssertions();
    }

    public function test_update_from_person_and_is_default_is_true_when_person_has_houses(): void
    {
        $this->housesPayload[1]['is_default'] = true;
        $this->housesPayload[2]['is_default'] = false;

        $this->mockedPersonService->shouldReceive('get')->once()->andReturn($this->fakePerson);
        $this->mockedHouseService->shouldReceive('get')->andReturn($this->fakeHouse1, $this->fakeHouse2, $this->fakeHouse3);
        $this->fakePerson->shouldReceive('houses')->andReturn($this->fakeBelongsToMany);
        $this->fakeBelongsToMany->shouldReceive('sync')->andReturnSelf();
        $this->fakeBelongsToMany->shouldReceive('get')->andReturn($this->fakePersonHouses);
        $this->fakeBelongsToMany->shouldReceive('updateExistingPivot')->andReturn();

        $this->mockedHousePersonService->updateFromPerson($this->personIdPayload, $this->housesPayload);

        $this->expectNotToPerformAssertions();
    }

    public function test_update_from_person_and_is_default_is_false_when_person_has_houses(): void
    {
        $this->housesPayload[2]['is_default'] = false;

        $this->mockedPersonService->shouldReceive('get')->once()->andReturn($this->fakePerson);
        $this->mockedHouseService->shouldReceive('get')->andReturn($this->fakeHouse1, $this->fakeHouse2, $this->fakeHouse3);
        $this->fakePerson->shouldReceive('houses')->andReturn($this->fakeBelongsToMany);
        $this->fakeBelongsToMany->shouldReceive('sync')->andReturnSelf();
        $this->fakeBelongsToMany->shouldReceive('get')->andReturn($this->fakePersonHouses);

        $this->expectException(Exception::class);

        $this->mockedHousePersonService->updateFromPerson($this->personIdPayload, $this->housesPayload);
    }

    public function test_update_from_person_when_user_already_has_a_house_with_city_id_and_description(): void
    {
        $this->fakeHouse1 = Mockery::mock(House::class)->makePartial();
        $this->fakeHouse1->city_id = 1;
        $this->fakeHouse1->description = 'House 30';

        $this->fakeHouse2 = Mockery::mock(House::class)->makePartial();
        $this->fakeHouse2->city_id = 1;
        $this->fakeHouse2->description = 'House 31';

        $pivot = new stdClass();
        $pivot->is_default = true;

        $this->fakeHouse1->shouldReceive('getAttribute')->with('city')->andReturn(new City());
        $this->fakeHouse1->shouldReceive('getAttribute')->with('pivot')->andReturn($pivot);
        $this->fakeHouse2->shouldReceive('getAttribute')->with('city')->andReturn(new City());
        $this->fakeHouse2->shouldReceive('getAttribute')->with('pivot')->andReturn($pivot);
        $this->mockedPersonService->shouldReceive('get')->once()->andReturn($this->fakePerson);
        $this->mockedHouseService->shouldReceive('get')->andReturn($this->fakeHouse1, $this->fakeHouse1, $this->fakeHouse1, $this->fakeHouse2, $this->fakeHouse3);
        $this->fakePerson->shouldReceive('houses')->andReturn($this->fakeBelongsToMany);
        $this->fakeBelongsToMany->shouldReceive('sync')->andReturnSelf();
        $this->fakeBelongsToMany->shouldReceive('get')->andReturn($this->fakePersonHouses);

        $this->expectException(Exception::class);

        $this->mockedHousePersonService->updateFromPerson($this->personIdPayload, $this->housesPayload);
    }
}
