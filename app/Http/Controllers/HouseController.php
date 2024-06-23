<?php

namespace App\Http\Controllers;

use App\Contracts\Services\HousePersonService\HousePersonServiceInterface;
use App\Contracts\Services\HouseService\HouseServiceInterface;
use App\Exceptions\OperationNotAllowedException;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Requests\HousePersonRequest;
use App\Http\Requests\HouseRequest;
use Symfony\Component\HttpFoundation\Response;

class HouseController extends Controller
{
    private $fields = ['description', 'city_id'];

    public function __construct(
        private readonly HouseServiceInterface $houseService,
        private readonly HousePersonServiceInterface $housePersonService) {}

    public function store(HouseRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $house = $this->houseService->create($validated);

        return response()->noContent(Response::HTTP_CREATED)
                    ->header('Location', url('/api/house/'.$house->id));
    }

    public function update(int $houseId, HouseRequest $request)
    {
        $validated = $request->safe()->only($this->fields);

        try {
            $this->houseService->update($houseId, $validated);
            return response()->noContent(Response::HTTP_NO_CONTENT);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }
    }

    public function list()
    {
        return $this->houseService->getList();
    }

    public function get(int $houseId)
    {
        try {
            return response()->json($this->houseService->get($houseId), Response::HTTP_OK);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }
    }

    public function storePersons(int $houseId, HousePersonRequest $request)
    {
        $validated = $request->safe()->only(['persons']);
        $persons = $validated['persons'];

        try {
            $this->housePersonService->createFromHouse($houseId, $persons);
            return response()->noContent(Response::HTTP_CREATED);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }
    }

    public function updatePersons(int $houseId, HousePersonRequest $request)
    {
        $validated = $request->safe()->only(['persons']);
        $persons = $validated['persons'];

        try {
            $this->housePersonService->updateFromHouse($houseId, $persons);
            return response()->noContent(Response::HTTP_NO_CONTENT);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }
    }

    public function enable(int $houseId)
    {
        try {
            $this->houseService->enable($houseId);
            return response()->noContent(Response::HTTP_NO_CONTENT);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        } catch (OperationNotAllowedException $exception) {
            return response()->noContent(Response::HTTP_BAD_REQUEST);
        }
    }

    public function disable(int $houseId)
    {
        try {
            $this->houseService->disable($houseId);
            return response()->noContent(Response::HTTP_NO_CONTENT);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        } catch (OperationNotAllowedException $exception) {
            return response()->noContent(Response::HTTP_BAD_REQUEST);
        }
    }
}
