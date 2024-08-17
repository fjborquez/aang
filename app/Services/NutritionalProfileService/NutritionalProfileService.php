<?php

namespace App\Services\NutritionalProfileService;

use App\Contracts\Services\NutritionalProfileService\NutritionalProfileServiceInterface;
use App\Contracts\Services\PersonService\PersonServiceInterface;
use App\Exceptions\IllegalArgumentException;
use App\Models\NutritionalProfile;

use function PHPUnit\Framework\isEmpty;

class NutritionalProfileService implements NutritionalProfileServiceInterface
{
    public function __construct(
        private readonly PersonServiceInterface $personService,
    ) {}

    public function create(int $personId, array $data = [])
    {
        if (empty($data)) {
            throw new IllegalArgumentException('Nutritional profile data cannot be empty');
        }

        if ($personId < 1) {
            throw new IllegalArgumentException('Invalid person id');
        }

        foreach ($data as $profileDetail) {
            $nutritionalProfile = new NutritionalProfile();
            $nutritionalProfile->product_category_id = $profileDetail['product_category_id'];
            $nutritionalProfile->product_category_name = $profileDetail['product_category_name'];
            $nutritionalProfile->consumption_level_id = $profileDetail['consumption_level_id'];
            $nutritionalProfile->person_id = $personId;
            $nutritionalProfile->save();
        }
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
}
