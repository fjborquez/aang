<?php

namespace Tests\Unit\App\Services\UserService;

use Tests\TestCase;
use App\Models\UserProfile;
use Mockery;
use App\Contracts\Services\UserProfileService\UserProfileServiceInterface;
use App\Services\UserProfileService\UserProfileService;

class UserProfileServiceTest extends TestCase
{
    function test_should_create_new_user_profile_when_user_profile_factory_create() {
        $userProfileMock = Mockery::mock(UserProfile::class);
        $userProfileFactoryMock = Mockery::mock(UserProfileFactory::class);

        $userProfileMock->shouldReceive('factory')->once()->andReturn($userProfileFactoryMock);
        $userProfileFactoryMock->shouldReceive('create')->once()->andReturn(new UserProfile);
        $userProfileMock->shouldReceive('where')->once()->andReturn($userProfileMock);
        $userProfileMock->shouldReceive('first')->once();

        $userProfileService = new UserProfileService($userProfileMock);
        $userProfileService->create(1, []);
    }

    function test_should_throw_an_exception_when_user_profile_exists() {
        $userProfileMock = Mockery::mock(UserProfile::class);
        $userProfileFactoryMock = Mockery::mock(UserProfileFactory::class);

        $userProfileMock->shouldReceive('where')->once()->andReturn($userProfileMock);
        $userProfileMock->shouldReceive('first')->once()->andReturn(new UserProfile);

        $userProfileService = new UserProfileService($userProfileMock);
        $this->expectException(\Exception::class);
        $userProfileService->create(1, []);
    }
}
