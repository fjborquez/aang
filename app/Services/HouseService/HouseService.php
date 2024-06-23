<?php

namespace App\Services\HouseService;

use App\Contracts\Services\HouseService\HouseServiceInterface;
use App\Exceptions\OperationNotAllowedException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\House;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class HouseService implements HouseServiceInterface
{
    public function __construct(private readonly House $house) {}

    public function create(array $data = []): House
    {
        return $this->house->factory()->create($data);
    }

    public function get(int $id): House
    {
        $house = $this->house->find($id);

        if ($house == null) {
            throw new ResourceNotFoundException('House not found');
        }

        return $house;
    }

    public function getList(): Collection
    {
        return $this->house->with('city')->get();
    }

    public function update(int $houseId, array $data = []): void
    {
        $house = $this->house->find($houseId);

        if ($house == null) {
            throw new ResourceNotFoundException('House not found');
        }

        $house->update($data);
    }

    public function enable(int $houseId): void
    {
        $house = $this->house->find($houseId);

        if ($house == null) {
            throw new ResourceNotFoundException('House not found');
        }

        if ($house->is_active) {
            throw new OperationNotAllowedException('House already enabled');
        }

        $house->update(['is_active' => true]);
    }

    public function disable(int $houseId): void
    {
        $house = $this->house->find($houseId);

        if ($house == null) {
            throw new ResourceNotFoundException('House not found');
        }

        if (! $house->is_active) {
            throw new OperationNotAllowedException('House already disabled');
        }

        foreach ($house->persons as $person) {
            if ($person->pivot->is_default) {
                throw new OperationNotAllowedException('Default house, can not be disabled');
            }
        }

        $house->update(['is_active' => false]);
    }
}
