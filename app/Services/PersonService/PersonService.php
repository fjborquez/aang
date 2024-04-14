<?php

namespace App\Services\PersonService;

use App\Contracts\Services\PersonService\PersonServiceInterface;
use App\Models\Person;

class PersonService implements PersonServiceInterface
{
    public function __construct(private readonly Person $person)
    {
    }

    public function create(array $data = []): Person
    {
        $person = $this->person->factory()->create($data);
        return $person;
    }

    public function getList()
    {
        return $this->person->with('nutritionalProfile')->get();
    }

    public function get(int $id): Person
    {
        return $this->person->find($id);
    }
}
