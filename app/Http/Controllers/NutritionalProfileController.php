<?php

namespace App\Http\Controllers;

use App\Exceptions\ResourceNotFoundException;
use App\Http\Requests\NutritionalProfileRequest;
use App\Services\NutritionalProfileService\NutritionalProfileService;
use Symfony\Component\HttpFoundation\Response;

class NutritionalProfileController extends Controller
{
    private $fields = ['nutritionalProfile'];

    public function __construct(private readonly NutritionalProfileService $nutritionalProfileService) {}

    public function store(int $personId, NutritionalProfileRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $nutritionalProfile = $validated['nutritionalProfile'];

        try {
            $this->nutritionalProfileService->create($personId, $nutritionalProfile);
            return response()->noContent(Response::HTTP_CREATED);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }

    }

    public function update(int $personId, NutritionalProfileRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $nutritionalProfile = $validated['nutritionalProfile'];

        try {
            $this->nutritionalProfileService->update($personId, $nutritionalProfile);
            return response()->noContent(Response::HTTP_OK);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }


    }

    public function get(int $personId)
    {
        try {
            return response()->json($this->nutritionalProfileService->get($personId), 200);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }
    }
}
