<?php

namespace App\Http\Controllers;

use App\Services\NutritionalProfileService\NutritionalProfileService;
use Illuminate\Http\Request;

class NutritionalProfileController extends Controller
{
    public function __construct(private readonly NutritionalProfileService $nutritionalProfileService) {}

    public function store(int $personId, Request $request)
    {
        $nutritionalProfile = $request->get('nutritionalProfile');
        $this->nutritionalProfileService->create($personId, $nutritionalProfile);
    }

    public function update(int $personId, Request $request)
    {
        $nutritionalProfile = $request->get('nutritionalProfile');
        $this->nutritionalProfileService->update($personId, $nutritionalProfile);

    }

    public function get(int $personId)
    {
        return $this->nutritionalProfileService->get($personId);
    }
}
