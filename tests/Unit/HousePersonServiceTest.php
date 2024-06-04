<?php

namespace Tests\Unit;

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
                "is_default" => false,
            ],
            2 => [
                "is_default" => true,
            ],
            3 => [
                "is_default" => false,
            ],
        ];

        $this->fakePerson = Mockery::mock(Person::class);
        $this->fakeBelongsToMany = Mockery::mock(BelongsToMany::class);
        $fakeHouse1 = new House();
        $fakeHouse1->id = 1;
        $fakeHouse1->description = "House 1";
        $fakeHouse1->city_id = 1;
        $fakeHouse2 = new House();
        $fakeHouse2->id = 2;
        $fakeHouse2->description = "House 2";
        $fakeHouse2->city_id = 2;
        $fakeHouse3 = new House();
        $fakeHouse3->id = 3;
        $fakeHouse3->description = "House 3";
        $fakeHouse3->city_id = 3;
        $this->fakePersonHouses = new Collection([
            $fakeHouse1,
            $fakeHouse2,
            $fakeHouse3,
        ]);

        $this->fakeHouse1 = new House();
        $this->fakeHouse1->id = 1;
        $this->fakeHouse1->description = "House 1";
        $this->fakeHouse1->city_id = 1;
        $this->fakeHouse2 = new House();
        $this->fakeHouse2->id = 2;
        $this->fakeHouse2->description = "House 2";
        $this->fakeHouse2->city_id = 2;
        $this->fakeHouse3 = new House();
        $this->fakeHouse3->id = 3;
        $this->fakeHouse3->description = "House 3";
        $this->fakeHouse3->city_id = 3;
    }

    public function test_update_from_person_successfully(): void
    {
        $this->mockedPersonService->shouldReceive('get')->once()->andReturn($this->fakePerson);
        $this->mockedHouseService->shouldReceive('get')->andReturn($this->fakeHouse1, $this->fakeHouse2, $this->fakeHouse3);
        $this->fakePerson->shouldReceive('houses')->andReturn($this->fakeBelongsToMany);
        $this->fakeBelongsToMany->shouldReceive('sync')->once()->andReturnSelf();
        $this->fakeBelongsToMany->shouldReceive('get')->andReturn($this->fakePersonHouses);
        $this->fakeBelongsToMany->shouldReceive('updateExistingPivot')->once()->andReturn();

        $this->mockedHousePersonService->updateFromPerson($this->personIdPayload, $this->housesPayload);

        $this->expectNotToPerformAssertions();
    }

    public function test_update_from_person_and_is_default_is_true_when_person_has_houses(): void
    {
        $this->housesPayload[1]["is_default"] = true;
        $this->housesPayload[2]["is_default"] = false;

        $this->mockedPersonService->shouldReceive('get')->once()->andReturn($this->fakePerson);
        $this->mockedHouseService->shouldReceive('get')->andReturn($this->fakeHouse1, $this->fakeHouse2, $this->fakeHouse3);
        $this->fakePerson->shouldReceive('houses')->andReturn($this->fakeBelongsToMany);
        $this->fakeBelongsToMany->shouldReceive('sync')->once()->andReturnSelf();
        $this->fakeBelongsToMany->shouldReceive('get')->andReturn($this->fakePersonHouses);
        $this->fakeBelongsToMany->shouldReceive('updateExistingPivot')->andReturn();

        $this->mockedHousePersonService->updateFromPerson($this->personIdPayload, $this->housesPayload);

        $this->expectNotToPerformAssertions();
    }

    public function test_update_from_person_and_is_default_is_false_when_person_has_houses(): void
    {
        $this->housesPayload[2]["is_default"] = false;

        $this->mockedPersonService->shouldReceive('get')->once()->andReturn($this->fakePerson);
        $this->mockedHouseService->shouldReceive('get')->andReturn($this->fakeHouse1, $this->fakeHouse2, $this->fakeHouse3);
        $this->fakePerson->shouldReceive('houses')->andReturn($this->fakeBelongsToMany);
        $this->fakeBelongsToMany->shouldReceive('sync')->once()->andReturnSelf();
        $this->fakeBelongsToMany->shouldReceive('get')->andReturn($this->fakePersonHouses);

        $this->expectException(Exception::class);

        $this->mockedHousePersonService->updateFromPerson($this->personIdPayload, $this->housesPayload);
    }

    public function test_update_from_person_when_user_already_has_a_house_with_city_id_and_description(): void
    {
        $this->fakeHouse1->city_id = 1;
        $this->fakeHouse1->description = "House 1";

        $this->fakeHouse2->city_id = 1;
        $this->fakeHouse2->description = "House 1";

        $this->mockedPersonService->shouldReceive('get')->once()->andReturn($this->fakePerson);
        $this->mockedHouseService->shouldReceive('get')->andReturn($this->fakeHouse1, $this->fakeHouse1, $this->fakeHouse1, $this->fakeHouse2, $this->fakeHouse3);
        $this->fakePerson->shouldReceive('houses')->andReturn($this->fakeBelongsToMany);
        $this->fakeBelongsToMany->shouldReceive('sync')->once()->andReturnSelf();
        $this->fakeBelongsToMany->shouldReceive('get')->andReturn($this->fakePersonHouses);

        $this->expectException(Exception::class);

        $this->mockedHousePersonService->updateFromPerson($this->personIdPayload, $this->housesPayload);
    }
}