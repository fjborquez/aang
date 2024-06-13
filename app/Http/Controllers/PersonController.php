<?php

namespace App\Http\Controllers;

use App\Contracts\Services\HousePersonService\HousePersonServiceInterface;
use App\Contracts\Services\PersonService\PersonServiceInterface;
use App\Http\Requests\PersonHouseRequest;
use App\Http\Requests\PersonRequest;
use Exception;

class PersonController extends Controller
{
    private array $fields = ['name', 'lastname', 'date_of_birth'];

    public function __construct(
        private readonly PersonServiceInterface $personService,
        private readonly HousePersonServiceInterface $housePersonService
    ) {
    }

    public function store(PersonRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $person = $this->personService->create($validated);

        return response()->json([
            'message' => 'Person added',
            'person' => $person,
        ], 201);
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

    public function delete(int $personId)
    {
        try {
            $this->personService->delete($personId);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }

        return response()->json([
            'message' => 'Person deleted',
        ], 200);
    }

    public function storeHouses(int $personId, PersonHouseRequest $request)
    {
        $validated = $request->safe()->only(['houses']);
        $houses = $validated['houses'];

        try {
            $this->housePersonService->createFromPerson($personId, $houses);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    public function updateHouses(int $personId, PersonHouseRequest $request)
    {
        $validated = $request->safe()->only(['houses']);
        $houses = $validated['houses'];

        try {
            $this->housePersonService->updateFromPerson($personId, $houses);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    public function getHouses(int $personId)
    {
        return $this->housePersonService->getHousesByPerson($personId);
    }
}
