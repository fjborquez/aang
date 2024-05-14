<?php

namespace App\Http\Controllers;

use App\Contracts\Services\HousePersonService\HousePersonServiceInterface;
use App\Contracts\Services\HouseService\HouseServiceInterface;
use App\Http\Requests\HousePersonRequest;
use App\Http\Requests\HouseRequest;
use Exception;

class HouseController extends Controller
{
    private $fields = ['description', 'city_id'];

    public function __construct(
        private readonly HouseServiceInterface $houseService,
        private readonly HousePersonServiceInterface $housePersonService)
    {
    }

    public function store(HouseRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $house = $this->houseService->create($validated);

        return response()->json([
            'message' => 'House added',
            'house' => $house
        ], 201);
    }

    public function update(int $houseId, HouseRequest $request)
    {
        $validated = $request->safe()->only($this->fields);

        try {
            $this->houseService->update($houseId, $validated);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 404);
        }

        return response()->json('House updated', 200);
    }

    public function list()
    {
        return $this->houseService->getList();
    }

    public function get(int $houseId)
    {
        try {
            return $this->houseService->get($houseId);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
    }

    public function storePersons(int $houseId, HousePersonRequest $request)
    {
        $validated = $request->safe()->only(['persons']);
        $persons = $validated['persons'];
        $this->housePersonService->createFromHouse($houseId, $persons);
    }

    public function updatePersons(int $houseId, HousePersonRequest $request)
    {
        $validated = $request->safe()->only(['persons']);
        $persons = $validated['persons'];

        try {
            $this->housePersonService->updateFromHouse($houseId, $persons);
        } catch(Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
    }
}
