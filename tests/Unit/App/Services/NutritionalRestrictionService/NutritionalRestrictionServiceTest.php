<?php

use App\Models\NutritionalRestriction;
use App\Services\NutritionalRestrictionService\NutritionalRestrictionService;
use function PHPUnit\Framework\assertEquals;

use Illuminate\Database\Eloquent\Collection;

use Tests\TestCase;

class NutritionalRestrictionServiceTest extends TestCase
{
    private $mockedNutritionalRestriction;
    private $nutritionalRestrictionService;

    public function setUp(): void
    {
        $this->mockedNutritionalRestriction = Mockery::mock(NutritionalRestriction::class);
        $this->nutritionalRestrictionService = new NutritionalRestrictionService($this->mockedNutritionalRestriction);
    }

    public function test_getList(): void
    {
        $this->mockedNutritionalRestriction->shouldReceive('all')->andReturn(new Collection());
        assertEquals(new Collection(), $this->nutritionalRestrictionService->getList());
    }

    public function test_get(): void
    {
        $this->mockedNutritionalRestriction->shouldReceive('find')->andReturn(new NutritionalRestriction);
        assertEquals(new NutritionalRestriction, $this->nutritionalRestrictionService->get(1));
    }
}
