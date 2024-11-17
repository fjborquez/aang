<?php

namespace App\Providers;

use App\Contracts\Services\CityService\CityServiceInterface;
use App\Services\CityService\CityService;
use Illuminate\Support\ServiceProvider;

class CityServiceProvider extends ServiceProvider
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
            CityServiceInterface::class,
            CityService::class
        );
    }
}
