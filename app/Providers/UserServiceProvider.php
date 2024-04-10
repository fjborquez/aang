<?php

namespace App\Providers;

use App\Contracts\Services\UserService\UserServiceInterface;
use Illuminate\Support\ServiceProvider;
USE App\Services\UserService\UserService;

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
