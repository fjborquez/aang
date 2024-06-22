<?php

use App\Models\Person;
use App\Services\NutritionalProfileService\NutritionalProfileService;
use App\Services\PersonService\PersonService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class NutritionalProfileServiceTest extends TestCase
{
    private $mockedPersonService;

    private $nutritionalProfileService;

    private $mockedPerson;

    private $mockedNutritionalProfileRelationship;

    public function setUp(): void
    {
        $this->mockedNutritionalProfileRelationship = Mockery::mock(BelongsToMany::class);
        $this->mockedPerson = Mockery::mock(Person::class);
        $this->mockedPersonService = Mockery::mock(PersonService::class);
        $this->nutritionalProfileService = new NutritionalProfileService($this->mockedPersonService);
    }

    public function test_should_create_a_profile_when_person_exists(): void
    {
        $this->mockedNutritionalProfileRelationship->shouldReceive('sync')->once()->andReturn(true);
        $this->mockedPersonService->shouldReceive('get')->once()->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('nutritionalProfile')->once()->andReturn($this->mockedNutritionalProfileRelationship);
        $this->nutritionalProfileService->create(1, []);
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
        $this->mockedNutritionalProfileRelationship->shouldReceive('sync')->once()->andReturn(true);
        $this->mockedPersonService->shouldReceive('get')->once()->andReturn($this->mockedPerson);
        $this->mockedPerson->shouldReceive('nutritionalProfile')->once()->andReturn($this->mockedNutritionalProfileRelationship);
        $this->nutritionalProfileService->update(1, []);
    }
}
