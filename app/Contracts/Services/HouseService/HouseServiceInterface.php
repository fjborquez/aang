<?php

namespace App\Contracts\Services\HouseService;

use App\Models\House;
use Illuminate\Database\Eloquent\Collection;

interface HouseServiceInterface
{
    public function create(array $data = []): House;

    public function getList(): Collection;

    public function update(int $houseId, array $data = []): void;

    public function get(int $houseId): House;

    public function enable(int $houseId): void;

    public function disable(int $houseId): void;
}
