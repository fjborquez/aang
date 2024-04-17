<?php

namespace App\Services\HousePersonService;

use App\Contracts\Services\HousePersonService\HousePersonServiceInterface;
use App\Services\HouseService\HouseService;
use App\Services\PersonService\PersonService;



class HousePersonService implements HousePersonServiceInterface
{
    public function __construct(
        private readonly HouseService $houseService,
        private readonly PersonService $personService
    )
    {
    }

    public function createFromHouse(int $houseId, array $persons): void
    {
        $house = $this->houseService->get($houseId);

        foreach ($persons as $id => $values)
        {
            $person = $this->personService->get($id);

            if ($person->houses()->count() == 0) {
                $persons[$id]['is_default'] = true;
            }
        }

        $house->persons()->sync($persons);
    }
}
