<?php

namespace App\Services\ResidentService;

use App\Contracts\Services\ResidentService\ResidentServiceInterface;
use App\Models\Person;

class ResidentService implements ResidentServiceInterface
{
    public function __construct(private readonly Person $person)
    {

    }

    public function list(int $houseId)
    {
        return $this->person->whereHas('houses', function ($query) use ($houseId) {
            $query->where('id', $houseId);
        })->get();
    }
}
