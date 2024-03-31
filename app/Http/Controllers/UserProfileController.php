<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserProfileRequest;
use App\Contracts\Services\UserProfileService\UserProfileServiceInterface;

class UserProfileController extends Controller
{
    public function __construct(private readonly UserProfileServiceInterface $userProfileService)
    {
    }

    public function store(int $userId, StoreUserProfileRequest $request)
    {
        $validated = $request->safe()->only(['date_of_birth', 'is_vegetarian', 'is_vegan',
            'is_celiac', 'is_keto', 'is_diabetic', 'is_lactose', 'is_gluten']);
        $userProfile = $this->userProfileService->create($userId, $validated);
        return response()->json('User profile added', 201);
    }
}
