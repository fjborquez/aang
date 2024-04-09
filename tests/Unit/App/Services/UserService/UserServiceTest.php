<?php

namespace Tests\Unit\App\Services\UserService;

use App\Models\User;
use App\Services\UserService\UserService;
use Exception;
use Mockery;
use Tests\TestCase;

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

    function test_should_delete_user(): void
    {
        $userId = 1;
        $userMock = Mockery::mock(User::class);

        $userMock->shouldReceive('delete')->once()->andReturnSelf();
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
        $userMock->shouldReceive('with')->once()->andReturn($userMock);

        $userService = new UserService($userMock);
        $userService->get($userId);
    }

    function test_should_not_get_user_by_id_when_user_not_exists()
    {
        $userId = 1;
        $userMock = Mockery::mock(User::class);
        $this->expectException(Exception::class);

        $userMock->shouldReceive('with')->once()->andReturn($userMock);
        $userMock->shouldReceive('find')->once()->andReturn(null);

        $userService = new UserService($userMock);
        $userService->get($userId);
    }

    function test_should_throw_an_exception_when_user_not_exists_when_enable()
    {
        $userId = 1;
        $userMock = Mockery::mock(User::class);
        $this->expectException(Exception::class);

        $userMock->shouldReceive('find')->once()->andReturn(null);

        $userService = new UserService($userMock);
        $userService->enable($userId);
    }

    function test_should_throw_an_exception_when_user_is_active()
    {
        $userId = 1;
        $userMock = Mockery::mock(User::class);
        $this->expectException(Exception::class);

        $userMock->is_active = true;
        $userMock->shouldReceive('find')->once()->andReturn($userMock);

        $userService = new UserService($userMock);
        $userService->enable($userId);
    }

    function test_should_enable_user_when_user_is_disabled()
    {
        $userId = 1;
        $userMock = Mockery::mock(User::class);

        $userMock->shouldReceive('find')->once()->andReturn($userMock);
        $userMock->shouldReceive('update')->once()->andReturnSelf();
        $userMock->shouldReceive('getAttribute')->once()->andReturn(false);

        $userService = new UserService($userMock);
        $userService->enable($userId);
    }

    function test_should_throw_an_exception_when_user_not_exists_when_disable()
    {
        $userId = 1;
        $userMock = Mockery::mock(User::class);
        $this->expectException(Exception::class);

        $userMock->shouldReceive('find')->once()->andReturn(null);

        $userService = new UserService($userMock);
        $userService->disable($userId);
    }

    function test_should_throw_an_exception_when_user_is_not_active()
    {
        $userId = 1;
        $userMock = Mockery::mock(User::class);
        $this->expectException(Exception::class);

        $userMock->is_active = false;
        $userMock->shouldReceive('find')->once()->andReturn($userMock);

        $userService = new UserService($userMock);
        $userService->disable($userId);
    }

    function test_should_disable_user_when_user_is_enabled()
    {
        $userId = 1;
        $userMock = Mockery::mock(User::class);

        $userMock->shouldReceive('find')->once()->andReturn($userMock);
        $userMock->shouldReceive('update')->once()->andReturnSelf();
        $userMock->shouldReceive('getAttribute')->once()->andReturn(true);

        $userService = new UserService($userMock);
        $userService->disable($userId);
    }
}
