<?php

namespace App\Services\HousePersonService;

use App\Contracts\Services\HousePersonService\HousePersonServiceInterface;
use App\Models\House;
use App\Models\Person;
use App\Services\HouseService\HouseService;
use App\Services\PersonService\PersonService;
use Exception;
use Illuminate\Database\Eloquent\Collection;

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
            } else {
                if ($values['is_default'] == true) {
                    $this->validateDuplicatedHouseForPerson($person, $house);
                    $this->changeHouseByDefault($person);
                } else {
                    $this->validateDuplicatedHouseForPerson($person, $house);
                }
            }
        }

        $house->persons()->sync($persons);
    }

    public function createFromPerson(int $personId, array $houses): void
    {
        $person = $this->personService->get($personId);
        $index = 0;

        foreach ($houses as $x => $valuesX)
        {
            $houseX = $this->houseService->get($x);
            foreach($houses as $y => $valuesY) {
                $houseY = $this->houseService->get($y);

                if ($houseX->id == $houseY->id) {
                    continue;
                }

                if ($houseX->city_id == $houseY->city_id && $houseX->description == $houseY->description)
                {
                    throw new Exception("The user already has a house with description in city");
                }
            }
        }

        foreach ($houses as $id => $values)
        {
            $house = $this->houseService->get($id);

            if ($person->houses()->count() == 0 && $index == 0) {
                $houses[$id]['is_default'] = true;
            } else {
                if ($values['is_default'] == true) {
                    $this->validateDuplicatedHouseForPerson($person, $house);
                    $this->changeHouseByDefault($person);
                } else {
                    $this->validateDuplicatedHouseForPerson($person, $house);
                }
            }

            $index++;
        }


        $person->houses()->sync($houses);
    }

    public function validateDuplicatedHouseForPerson(Person $person, House $house)
    {
        foreach ($person->houses()->get() as $housePivot)
        {
            if ($house->description == $housePivot->description && $house->city_id == $housePivot->city_id)
            {
                throw new Exception("The user already has a house with description in city");
            }
        }
    }

    public function changeHouseByDefault(Person $person): void
    {
        foreach ($person->houses()->get() as $housePivot)
        {
            $person->houses()->updateExistingPivot($housePivot->id, ['is_default' => false]);
        }
    }

    public function getHousesByPerson(int $personId): Collection
    {
        $person = $this->personService->get($personId);

        return $person->houses()->withPivot('is_default')->get();
    }
}
