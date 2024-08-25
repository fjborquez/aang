<?php

namespace App\Services\HouseService;

use App\Contracts\Services\HouseService\HouseServiceInterface;
use App\Exceptions\OperationNotAllowedException;
use App\Models\House;
use App\Services\BaseService\BaseService;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Collection;

class HouseService extends BaseService implements HouseServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function get(int $id): House
    {
        $house = $this->getBaseModel()->find($id);

        if ($house == null) {
            throw new InvalidArgumentException('House not found');
        }

        return $house;
    }

    public function getList(): Collection
    {
        return $this->getBaseModel()->with('city')->get();
    }

    public function update(int $houseId, array $data = []): void
    {
        $house = $this->getBaseModel()->find($houseId);

        if ($house == null) {
            throw new InvalidArgumentException('House not found');
        }

        $house->update($data);
    }

    public function enable(int $houseId): void
    {
        $house = $this->getBaseModel()->find($houseId);

        if ($house == null) {
            throw new InvalidArgumentException('House not found');
        }

        if ($house->is_active) {
            throw new OperationNotAllowedException('House already enabled');
        }

        $house->update(['is_active' => true]);
    }

    /**
     * @throws InvalidArgumentException
     * @throws OperationNotAllowedException
     */
    public function disable(int $houseId): void
    {
        $house = $this->getBaseModel()->find($houseId);

        if ($house == null) {
            throw new InvalidArgumentException('House not found');
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
