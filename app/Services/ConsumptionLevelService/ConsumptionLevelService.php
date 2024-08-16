<?php

namespace App\Services\ConsumptionLevelService;

use App\Contracts\Services\ConsumptionLevelService\ConsumptionLevelServiceInterface;
use App\Models\ConsumptionLevel;
use Illuminate\Database\Eloquent\Collection;

class ConsumptionLevelService implements ConsumptionLevelServiceInterface
{
    public function __construct(private readonly ConsumptionLevel $consumptionLevel) {}

    public function getList(): Collection
    {
        return $this->consumptionLevel->all();
    }

    public function get(int $id): ?ConsumptionLevel
    {
        return $this->consumptionLevel->find($id);
    }
}
