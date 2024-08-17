<?php

namespace App\Services\NutritionalProfileService;

use App\Contracts\Services\NutritionalProfileService\NutritionalProfileServiceInterface;
use App\Contracts\Services\PersonService\PersonServiceInterface;
use App\Models\NutritionalProfile;
use InvalidArgumentException;

class NutritionalProfileService implements NutritionalProfileServiceInterface
{
    public function __construct(
        private readonly PersonServiceInterface $personService,
    ) {}

    public function create(int $personId, array $data = [])
    {
        $this->validate($personId, $data);

        foreach ($data as $profileDetail) {
            $nutritionalProfile = new NutritionalProfile;
            $nutritionalProfile->product_category_id = $profileDetail['product_category_id'];
            $nutritionalProfile->product_category_name = $profileDetail['product_category_name'];
            $nutritionalProfile->consumption_level_id = $profileDetail['consumption_level_id'];
            $nutritionalProfile->person_id = $personId;
            $nutritionalProfile->save();
        }

        return true;
    }

    public function get(int $personId): array
    {
        $person = $this->personService->get($personId);

        return $person->nutritionalProfile->toArray();
    }

    public function update(int $personId, array $data = [])
    {
        $person = $this->personService->get($personId);
        $person->nutritionalProfile()->sync($data);
    }

    private function validate(int $personId, array $data): void
    {
        if ($personId < 1) {
            throw new InvalidArgumentException('Invalid person id');
        }

        if (empty($data)) {
            throw new InvalidArgumentException('Nutritional profile data cannot be empty');
        }

        if ($this->hasInvalidConsumptionLevel($data)) {
            throw new InvalidArgumentException('Consumption level is invalid');
        }
    }

    private function hasInvalidConsumptionLevel(array $data): bool
    {
        return count(array_filter($data, function ($item) {
            return $item['consumption_level_id'] <= 0;
        })) > 0;
    }
}
