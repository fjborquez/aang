<?php

namespace App\Http\Controllers;

use App\Contracts\Services\HousePersonService\HousePersonServiceInterface;
use App\Contracts\Services\HouseService\HouseServiceInterface;
use App\Http\Requests\HousePersonRequest;
use App\Http\Requests\HouseRequest;

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
        $this->houseService->create($validated);
        return response()->json('House added', 201);
    }

    public function storePersons(int $houseId, HousePersonRequest $request)
    {
        $validated = $request->safe()->only(['persons']);
        $persons = $validated['persons'];
        $this->housePersonService->createFromHouse($houseId, $persons);
    }
}