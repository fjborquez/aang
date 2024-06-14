<?php

namespace App\Providers;

use App\Contracts\Services\UserService\UserServiceInterface;
use App\Services\UserService\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );
    }
}
