<?php

namespace App\Providers;

use App\Contracts\Services\HousePersonService\HousePersonServiceInterface;
use App\Services\HousePersonService\HousePersonService;
use Illuminate\Support\ServiceProvider;

class HousePersonServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->app->bind(
            HousePersonServiceInterface::class,
            HousePersonService::class
        );
    }
}
