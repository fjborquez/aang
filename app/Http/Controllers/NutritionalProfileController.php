<?php

namespace App\Http\Controllers;

use App\Services\NutritionalProfileService\NutritionalProfileService;
use Illuminate\Http\Request;

class NutritionalProfileController extends Controller
{

    public function __construct(private readonly NutritionalProfileService $nutritionalProfileService)
    {
    }

    public function store(int $userId, Request $request)
    {
        $nutritionalProfile = $request->get('nutritionalProfile');
        $this->nutritionalProfileService->create($userId, $nutritionalProfile);
    }

    public function update(int $userId, Request $request)
    {

    }
}
