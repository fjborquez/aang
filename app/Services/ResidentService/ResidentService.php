<?php

namespace App\Services\ResidentService;

use App\Contracts\Services\ResidentService\ResidentServiceInterface;
use App\Models\Person;
use Illuminate\Database\Eloquent\Builder;

class ResidentService implements ResidentServiceInterface
{
    public function __construct(private readonly Person $person) {}

    public function getList(int $houseId)
    {
        return $this->person->whereHas('houses', function (Builder $query) use ($houseId) {
            $query->where('id', $houseId);
        })->get();
    }
}
