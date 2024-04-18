<?php

namespace App\Http\Controllers;

use App\Contracts\Services\HousePersonService\HousePersonServiceInterface;
use App\Contracts\Services\PersonService\PersonServiceInterface;
use App\Http\Requests\PersonHouseRequest;
use App\Http\Requests\PersonRequest;

class PersonController extends Controller
{
    private array $fields = ['name', 'lastname', 'date_of_birth'];

    public function __construct(
        private readonly PersonServiceInterface $personService,
        private readonly HousePersonServiceInterface $housePersonService
    ){
    }

    public function store(PersonRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $this->personService->create($validated);
        return response()->json('Person added', 201);
    }

    public function update(int $id, PersonRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $this->personService->update($id, $validated);
        return response()->json('Person updated', 200);
    }

    public function list()
    {
        return $this->personService->getList();
    }

    public function get(int $personId)
    {
        return $this->personService->get($personId);
    }

    public function storeHouses(int $personId, PersonHouseRequest $request)
    {
        $validated = $request->safe()->only(['houses']);
        $houses = $validated['houses'];
        $this->housePersonService->createFromPerson($personId, $houses);
    }

    public function getHouses(int $personId)
    {
        return $this->housePersonService->getHousesByPerson($personId);
    }
}
