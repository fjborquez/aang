<?php

namespace App\Contracts\Services\HouseService;

use App\Models\House;

interface HouseServiceInterface
{
    public function create(array $data = []): House;
}
