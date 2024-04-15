<?php

namespace App\Services\HouseService;

use App\Contracts\Services\HouseService\HouseServiceInterface;
use App\Models\House;

class HouseService implements HouseServiceInterface
{
    public function __construct(private readonly House $house)
    {
    }

    public function create(array $data = []): House
    {
        return $this->house->factory()->create($data);
    }
}
