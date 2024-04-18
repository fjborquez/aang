<?php

namespace App\Contracts\Services\HouseService;

use App\Models\House;
use Illuminate\Database\Eloquent\Collection;

interface HouseServiceInterface
{
    public function create(array $data = []): House;

    public function getList(): Collection;
}
