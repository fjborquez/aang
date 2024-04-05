<?php

namespace App\Services\UserProfileService;

use App\Models\UserProfile;
use Exception;
use App\Contracts\Services\UserProfileService\UserProfileServiceInterface;

class UserProfileService implements UserProfileServiceInterface
{
    public function __construct(
        private readonly UserProfile $userProfile,
    ) {
    }

    public function create(int $userId, array $data = []): UserProfile
    {
        $profile = $this->userProfile->where('user_id', $userId)->first();

        if ($profile) {
            throw new Exception('The user already have a profile');
        }

        $data['user_id'] = $userId;
        $profile = $this->userProfile->factory()->create($data);

        return $profile;
    }

    public function update(int $userId, array $data = [])
    {
        $profile = $this->userProfile->where('user_id', $userId)->first();

        if (!$profile) {
            throw new Exception('The user does not have a profile');
        }

        $profile->update($data);

        return $profile;
    }

    public function get(int $userId)
    {
        $userProfile = $this->userProfile->where('user_id', $userId)->first();

        if ($userProfile == null)
        {
            throw new Exception('The user does not have a profile');
        }

        return $userProfile;
    }
}
