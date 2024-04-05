<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserProfileRequest;
use App\Contracts\Services\UserProfileService\UserProfileServiceInterface;

class UserProfileController extends Controller
{
    private $fields = ['date_of_birth', 'is_vegetarian', 'is_vegan', 'is_celiac', 'is_keto', 'is_diabetic', 'is_lactose', 'is_gluten'];

    public function __construct(private readonly UserProfileServiceInterface $userProfileService)
    {
    }

    public function store(int $userId, StoreUserProfileRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $userProfile = $this->userProfileService->create($userId, $validated);
        return response()->json('User profile added', 201);
    }

    public function update(int $userId, StoreUserProfileRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $this->userProfileService->update($userId, $validated);
        return response()->json('User profile updated', 200);
    }
}
