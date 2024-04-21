<?php

namespace App\Services\HouseService;

use App\Contracts\Services\HouseService\HouseServiceInterface;
use App\Models\House;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class HouseService implements HouseServiceInterface
{
    public function __construct(private readonly House $house)
    {
    }

    public function create(array $data = []): House
    {
        return $this->house->factory()->create($data);
    }

    public function get(int $id): House
    {
        $house = $this->house->find($id);

        if ($house == null) {
            throw new Exception('House not found');
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
            throw new Exception('House not found');
        }

        $house->update($data);
    }
}
