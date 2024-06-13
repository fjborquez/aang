<?php

namespace Tests\Unit\App\Services\PersonService;

use App\Models\Person;
use App\Services\PersonService\PersonService;
use Database\Factories\PersonFactory;
use Exception;
use Mockery;
use Tests\TestCase;

class PersonServiceTest extends TestCase
{
    function test_should_create_new_person_when_person_factory_create(): void
    {
        $personMock = Mockery::mock(Person::class);
        $personFactoryMock = Mockery::mock(PersonFactory::class);

        $personMock->shouldReceive('factory')->once()->andReturn($personFactoryMock);
        $personFactoryMock->shouldReceive('create')->once()->andReturn(new Person);

        $personService = new PersonService($personMock);
        $personService->create([
            'name' => '',
            'lastname' => '',
            'date_of_birth' => '',
        ]);
    }

    /*function test_should_update_person_when_person_exists()
    {
        $personId = 1;
        $data = [];
        $personMock = Mockery::mock(Person::class);

        $personMock->shouldReceive('find')->once()->andReturn($personMock);
        $personMock->shouldReceive('update')->once()->andReturnSelf();

        $personService = new PersonService($personMock);
        $personService->update($personId, $data);
    }*/

    /*function test_should_not_update_person_when_person_not_exists()
    {
        $personId = 1;
        $data = [];
        $personMock = Mockery::mock(Person::class);
        $this->expectException(Exception::class);

        $personMock->shouldReceive('find')->once()->andReturn(null);

        $personService = new PersonService($personMock);
        $personService->update($personId, $data);
    }*/

    function test_should_get_person_by_id_when_person_exists()
    {
        $personId = 1;
        $personMock = Mockery::mock(Person::class);

        $personMock->shouldReceive('find')->once()->andReturn($personMock);
        $personMock->shouldReceive('with')->andReturn($personMock);

        $personService = new PersonService($personMock);
        $personService->get($personId);
    }

    function test_should_not_get_person_by_id_when_person_not_exists()
    {
        $personId = 1;
        $personMock = Mockery::mock(Person::class);
        $this->expectException(Exception::class);

        $personMock->shouldReceive('with')->andReturn($personMock);
        $personMock->shouldReceive('find')->once()->andReturn(null);

        $personService = new PersonService($personMock);
        $personService->get($personId);
    }
}
