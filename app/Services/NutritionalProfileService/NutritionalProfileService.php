<?php

namespace App\Services\NutritionalProfileService;

use App\Contracts\Services\NutritionalProfileService\NutritionalProfileServiceInterface;
use App\Contracts\Services\PersonService\PersonServiceInterface;

class NutritionalProfileService implements NutritionalProfileServiceInterface
{
    public function __construct(
        private readonly PersonServiceInterface $personService,
    ){
    }

    public function create(int $userId, array $data = [])
    {
        $person = $this->personService->get($userId);
        $person->nutritionalProfile()->sync($data);
    }
}
