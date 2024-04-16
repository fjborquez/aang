<?php

namespace App\Contracts\Services\HousePersonService;

interface HousePersonServiceInterface
{
    public function createFromHouse(int $houseId, array $persons): void;
}
