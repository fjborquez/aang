<?php

namespace App\Http\Controllers;

use App\Contracts\Services\PersonService\PersonServiceInterface;
use App\Http\Requests\PersonRequest;

class PersonController extends Controller
{
    private array $fields = ['name', 'lastname', 'date_of_birth'];

    public function __construct(private readonly PersonServiceInterface $personService)
    {
    }

    public function store(PersonRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $this->personService->create($validated);
        return response()->json('Person added', 201);
    }

    public function list()
    {
        return $this->personService->getList();
    }
}