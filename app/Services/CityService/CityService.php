<?php

namespace App\Services\CityService;

use App\Contracts\Services\CityService\CityServiceInterface;
use App\Models\City;

class CityService implements CityServiceInterface
{
    public function getList()
    {
        return City::all();
    }
}
