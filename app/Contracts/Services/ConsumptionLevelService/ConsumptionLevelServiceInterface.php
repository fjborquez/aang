<?php

namespace App\Contracts\Services\ConsumptionLevelService;

use App\Models\ConsumptionLevel;

interface ConsumptionLevelServiceInterface
{
    public function getList();

    public function get(int $id): ConsumptionLevel;
}
