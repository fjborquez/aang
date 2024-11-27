<?php

use App\Models\NutritionalRestriction;
use App\Services\NutritionalRestrictionService\NutritionalRestrictionService;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class NutritionalRestrictionServiceTest extends TestCase
{
    private $mockedNutritionalRestriction;

    private $nutritionalRestrictionService;

    protected function setUp(): void
    {
        $this->mockedNutritionalRestriction = Mockery::mock(NutritionalRestriction::class);
        $this->nutritionalRestrictionService = new NutritionalRestrictionService($this->mockedNutritionalRestriction);
    }

    public function test_get_list(): void
    {
        $this->mockedNutritionalRestriction->shouldReceive('all')->andReturn(new Collection);
        assertEquals(new Collection, $this->nutritionalRestrictionService->getList());
    }

    public function test_get(): void
    {
        $this->mockedNutritionalRestriction->shouldReceive('find')->andReturn(new NutritionalRestriction);
        assertEquals(new NutritionalRestriction, $this->nutritionalRestrictionService->get(1));
    }
}
