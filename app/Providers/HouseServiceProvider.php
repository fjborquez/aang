<?php

namespace App\Providers;

use App\Contracts\Services\HouseService\HouseServiceInterface;
use App\Services\HouseService\HouseService;
use Illuminate\Support\ServiceProvider;

class HouseServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->app->bind(
            HouseServiceInterface::class,
            HouseService::class
        );
    }
}
