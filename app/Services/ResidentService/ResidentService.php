<?php

namespace App\Services\ResidentService;

use App\Contracts\Services\ResidentService\ResidentServiceInterface;
use App\Exceptions\ResourceNotFoundException;
use App\Models\House;
use App\Models\Person;
use Illuminate\Database\Eloquent\Builder;

class ResidentService implements ResidentServiceInterface
{
    public function __construct(
        private readonly Person $person,
        private readonly House $house
    ) {}

    public function getList(int $houseId)
    {
        return $this->person->whereHas('houses', function (Builder $query) use ($houseId) {
            $query->where('id', $houseId);
        })->get();
    }

    public function delete(int $houseId, int $residentId)
    {
        $house = $this->house->with('persons')->find($houseId);

        if ($house == null)
        {
            throw new ResourceNotFoundException('House not found');
        }

        $resident = $this->person->with('houses')->with('user')->find($residentId);

        if ($resident == null)
        {
            throw new ResourceNotFoundException('Resident not found');
        }

        if (! $house->persons()->contains($resident))
        {
            throw new ResourceNotFoundException('Resident does not belong to house');
        }

        if ($resident->user) {
            $this->syncHouses($houseId, $resident);
        } elseif ($resident->houses->count() > 1) {
            $this->syncHouses($houseId, $resident);
        } else {
            $resident->delete();
        }
    }

    private function syncHouses(int $houseId, Person $resident): void
    {
        $houses = $resident->houses()->get()->filter(function ($house) use ($houseId) {
            return $house != $houseId;
        });
        $resident->houses()->sync($houses->toArray());
    }
}
