<?php

namespace App\Contracts\Services\HousePersonService;

use Illuminate\Database\Eloquent\Collection;

interface HousePersonServiceInterface
{
    public function createFromHouse(int $houseId, array $persons): void;

    public function createFromPerson(int $personId, array $houses): void;

    public function getHousesByPerson(int $personId): Collection;

    public function updateFromHouse(int $houseId, array $persons): void;

    public function updateFromPerson(int $personId, array $houses): void;
}
