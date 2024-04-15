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
        return $this->person->with('nutritionalProfile')->with('user')->get();
    }

    public function get(int $id): Person
    {
        return $this->person->with('nutritionalProfile')->with('user')->find($id);
    }

    public function update(int $id, array $data = []): void
    {
        $person = $this->person->find($id);

        if ($person == null) {
            throw new Exception('Person not found');
        }

        $person->update($data);
    }
}
