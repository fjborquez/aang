<?php

namespace App\Http\Controllers;

use App\Contracts\Services\HousePersonService\HousePersonServiceInterface;
use App\Contracts\Services\PersonService\PersonServiceInterface;
use App\Exceptions\OperationNotAllowedException;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Requests\PersonHouseRequest;
use App\Http\Requests\PersonRequest;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends Controller
{
    private array $fields = ['name', 'lastname', 'date_of_birth'];

    public function __construct(
        private readonly PersonServiceInterface $personService,
        private readonly HousePersonServiceInterface $housePersonService
    ) {}

    public function store(PersonRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $person = $this->personService->create($validated);

        return response()->noContent(Response::HTTP_CREATED)
                    ->header('Location', url('/api/person/'.$person->id));
    }

    public function update(int $id, PersonRequest $request)
    {
        $validated = $request->safe()->only($this->fields);

        try {
            $this->personService->update($id, $validated);
            return response()->noContent(Response::HTTP_NO_CONTENT);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }
    }

    public function list()
    {
        return $this->personService->getList();
    }

    public function get(int $personId)
    {
        try {
            return response()->json($this->personService->get($personId), 200);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }

    }

    public function delete(int $personId)
    {
        try {
            $this->personService->delete($personId);
            return response()->noContent(Response::HTTP_NO_CONTENT);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }
    }

    public function storeHouses(int $personId, PersonHouseRequest $request)
    {
        $validated = $request->safe()->only(['houses']);
        $houses = $validated['houses'];

        try {
            $this->housePersonService->createFromPerson($personId, $houses);
            return response()->noContent(Response::HTTP_NO_CONTENT);
        } catch (OperationNotAllowedException $exception) {
            return response()->noContent(Response::HTTP_BAD_REQUEST);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }
    }

    public function updateHouses(int $personId, PersonHouseRequest $request)
    {
        $validated = $request->safe()->only(['houses']);
        $houses = $validated['houses'];

        try {
            $this->housePersonService->updateFromPerson($personId, $houses);
            return response()->noContent(Response::HTTP_NO_CONTENT);
        } catch (OperationNotAllowedException $exception) {
            return response()->noContent(Response::HTTP_BAD_REQUEST);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }
    }

    public function getHouses(int $personId)
    {
        try {
            return response()->json($this->housePersonService->getHousesByPerson($personId), 200);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }
    }
}
