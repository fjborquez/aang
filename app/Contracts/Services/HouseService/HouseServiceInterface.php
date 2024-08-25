<?php

namespace App\Contracts\Services\HouseService;

use Illuminate\Database\Eloquent\Collection;

interface HouseServiceInterface
{
    public function getList(): Collection;

    public function update(int $houseId, array $data = []): void;

    public function enable(int $houseId): void;

    public function disable(int $houseId): void;
}
