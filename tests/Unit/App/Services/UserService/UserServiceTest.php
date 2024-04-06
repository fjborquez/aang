<?php

namespace Tests\Unit\App\Services\UserService;

use Tests\TestCase;
use App\Models\User;
use Mockery;
use App\Contracts\Services\UserService\UserServiceInterface;
use App\Services\UserService\UserService;
use Illuminate\Support\Facades\App;
use App\Contracts\Factories\UserFactory\UserFactoryInterface;
use Exception;

class UserServiceTest extends TestCase
{
    function test_should_create_new_user_when_user_factory_create(): void
    {
        $userMock = Mockery::mock(User::class);
        $userFactoryMock = Mockery::mock(UserFactory::class);

        $userMock->shouldReceive('factory')->once()->andReturn($userFactoryMock);
        $userFactoryMock->shouldReceive('create')->once()->andReturn(new User);

        $userService = new UserService($userMock);
        $userService->create([
            'name' => '',
            'lastname' => '',
            'email' => '',
            'password' => '',
        ]);
    }

    function test_should_delete_user_with_user_profile(): void
    {
        $userId = 1;
        $userMock = Mockery::mock(User::class);
        $userProfileMock = Mockery::mock(UserProfile::class);

        $userProfileMock->shouldReceive('delete')->once()->andReturnSelf();
        $userMock->shouldReceive('delete')->once()->andReturnSelf();
        $userMock->shouldReceive('getAttribute')->once()->andReturn($userProfileMock);
        $userMock->shouldReceive('find')->once()->andReturn($userMock);

        $userService = new UserService($userMock);
        $userService->delete($userId);
    }

    function test_should_delete_user_without_user_profile(): void
    {
        $userId = 1;
        $userMock = Mockery::mock(User::class);

        $userMock->shouldReceive('delete')->once()->andReturnSelf();
        $userMock->shouldReceive('getAttribute')->once()->andReturn(null);
        $userMock->shouldReceive('find')->once()->andReturn($userMock);

        $userService = new UserService($userMock);
        $userService->delete($userId);
    }

    function test_should_update_user_when_user_exists()
    {
        $userId = 1;
        $data = [];
        $userMock = Mockery::mock(User::class);

        $userMock->shouldReceive('find')->once()->andReturn($userMock);
        $userMock->shouldReceive('update')->once()->andReturnSelf();

        $userService = new UserService($userMock);
        $userService->update($userId, $data);
    }

    function test_should_not_update_user_when_user_not_exists()
    {
        $userId = 1;
        $data = [];
        $userMock = Mockery::mock(User::class);
        $this->expectException(Exception::class);

        $userMock->shouldReceive('find')->once()->andReturn(null);

        $userService = new UserService($userMock);
        $userService->update($userId, $data);
    }

    function test_should_get_user_by_id_when_user_exists()
    {
        $userId = 1;
        $userMock = Mockery::mock(User::class);

        $userMock->shouldReceive('find')->once()->andReturn($userMock);

        $userService = new UserService($userMock);
        $userService->get($userId);
    }

    function test_should_not_get_user_by_id_when_user_not_exists()
    {
        $userId = 1;
        $userMock = Mockery::mock(User::class);
        $this->expectException(Exception::class);

        $userMock->shouldReceive('find')->once()->andReturn(null);

        $userService = new UserService($userMock);
        $userService->get($userId);
    }
}
