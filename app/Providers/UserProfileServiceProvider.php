<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\UserProfileService\UserProfileServiceInterface;
use App\Services\UserProfileService\UserProfileService;

class UserProfileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(
            UserProfileServiceInterface::class,
            UserProfileService::class
        );
    }
}
