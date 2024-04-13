<?php

namespace App\Contracts\Services\PersonService;

use App\Models\Person;

interface PersonServiceInterface {
    function create(array $data = []): Person;

    function getList();
}
