<?php

namespace App\Services\NutritionalProfileService;

use App\Contracts\Services\NutritionalProfileService\NutritionalProfileServiceInterface;
use App\Contracts\Services\PersonService\PersonServiceInterface;

class NutritionalProfileService implements NutritionalProfileServiceInterface
{
    public function __construct(
        private readonly PersonServiceInterface $personService,
    ) {
    }

    public function create(int $personId, array $data = [])
    {
        $person = $this->personService->get($personId);
        $person->nutritionalProfile()->sync($data);
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
