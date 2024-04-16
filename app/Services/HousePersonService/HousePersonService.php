<?php

namespace App\Services\HousePersonService;

use App\Contracts\Services\HousePersonService\HousePersonServiceInterface;
use App\Services\HouseService\HouseService;

class HousePersonService implements HousePersonServiceInterface
{
    public function __construct(private readonly HouseService $houseService)
    {
    }

    public function createFromHouse(int $houseId, array $persons): void
    {
        $house = $this->houseService->get($houseId);
        $house->persons()->sync($persons);
    }
}
