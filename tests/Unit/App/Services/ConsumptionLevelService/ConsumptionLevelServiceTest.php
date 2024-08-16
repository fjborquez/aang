<?php

namespace Tests\Unit\App\Services\ConsumptionLevelService;

use App\Models\ConsumptionLevel;
use App\Services\ConsumptionLevelService\ConsumptionLevelService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class ConsumptionLevelServiceTest extends TestCase
{
    private $mockedConsumptionLevel;

    private $consumptionLevelService;

    private function generateMockedConsumptionLevel()
    {
        return new Collection([
            [
                'id' => 1,
                'value' => 0,
                'name' => 'Null',
                'description' => 'This level indicates that the person should not consume products from this category under any circumstances due to their nutritional restriction.',
            ],
            [
                'id' => 2,
                'value' => 1,
                'name' => 'Very Low',
                'description' => 'Extremely limited consumption; almost never consumed. Only occasionally and in very small amounts.',
            ],
            [
                'id' => 3,
                'value' => 2,
                'name' => 'Low',
                'description' => 'Reduced consumption; can be consumed occasionally but always in small quantities and with caution.',
            ],
            [
                'id' => 4,
                'value' => 3,
                'name' => 'Moderate',
                'description' => 'Moderate consumption; allowed with some frequency, but not recommended in large quantities.',
            ],
            [
                'id' => 5,
                'value' => 4,
                'name' => 'High',
                'description' => 'Regular consumption; can be consumed often and in typical amounts without significant issues.',
            ],
            [
                'id' => 6,
                'value' => 5,
                'name' => 'Very High',
                'description' => 'Free consumption; the person can consume products from this category without any restriction.',
            ],
        ]);
    }

    public function setUp(): void
    {
        $this->mockedConsumptionLevel = Mockery::mock(ConsumptionLevel::class);
        $this->consumptionLevelService = new ConsumptionLevelService($this->mockedConsumptionLevel);
    }

    public function test_getList(): void
    {
        $mockData = $this->generateMockedConsumptionLevel();

        $this->mockedConsumptionLevel->shouldReceive('all')->andReturn($mockData);
        $result = $this->consumptionLevelService->getList();

        $this->assertCount(6, $result);
        $this->assertEquals($mockData, $result);
    }

    public function testFindConsumptionLevelById()
    {
        $mockItem = new ConsumptionLevel;
        $mockItem->value = 0;
        $mockItem->name = 'Null';
        $mockItem->description = null;

        $this->mockedConsumptionLevel->shouldReceive('find')->with(1)->andReturn($mockItem);
        $result = $this->consumptionLevelService->get(1);

        $this->assertEquals('Null', $result->name);
        $this->assertEquals(0, $result->value);
    }
}
