<?php

namespace App\Contracts\Services\UserProfileService;

use App\Models\UserProfile;

interface UserProfileServiceInterface
{
    public function create(int $userId, array $data = []): UserProfile;
}
