<?php

namespace App\Providers;

use App\Contracts\Services\ResidentService\ResidentServiceInterface;
use App\Services\ResidentService\ResidentService;
use Illuminate\Support\ServiceProvider;

class ResidentServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->app->bind(
            ResidentServiceInterface::class,
            ResidentService::class
        );
    }
}
