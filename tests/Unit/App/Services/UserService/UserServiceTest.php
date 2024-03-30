<?php

namespace Tests\Unit\App\Services\UserService;

use Tests\TestCase;
use App\Models\User;
use Mockery;
use App\Contracts\Services\UserService\UserServiceInterface;
use App\Services\UserService\UserService;
use Illuminate\Support\Facades\App;
use App\Contracts\Factories\UserFactory\UserFactoryInterface;

class UserServiceTest extends TestCase
{
    function test_should_create_new_user_when_user_factory_create() {
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
}
