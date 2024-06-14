<?php

namespace App\Contracts\Services\PersonService;

use App\Models\Person;

interface PersonServiceInterface
{
    public function create(array $data = []): Person;

    public function getList();

    public function get(int $id): Person;

    public function update(int $id, array $data = []): void;

    public function delete(int $id): void;
}
