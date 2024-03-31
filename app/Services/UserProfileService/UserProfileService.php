<?php

namespace App\Services\UserProfileService;

use App\Models\UserProfile;
use Exception;
use App\Contracts\Services\UserProfileService\UserProfileServiceInterface;

class UserProfileService implements UserProfileServiceInterface
{
    public function __construct(private readonly UserProfile $userProfile)
    {
    }

    public function create(int $userId, array $data = []): UserProfile
    {
        $profile = $this->userProfile->where('user_id', $userId)->first();

        if ($profile) {
            throw new Exception('The user already have a profile');
        }

        $data['user_id'] = $userId;
        $profile = $this->userProfile->create($data);

        return $profile;
    }
}
