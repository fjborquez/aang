<?php

namespace App\Providers;

use App\Contracts\Services\ConsumptionLevelService\ConsumptionLevelServiceInterface;
use App\Services\ConsumptionLevelService\ConsumptionLevelService;
use Illuminate\Support\ServiceProvider;

class ConsumptionLevelServiceProvider extends ServiceProvider
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
            ConsumptionLevelServiceInterface::class,
            ConsumptionLevelService::class
        );
    }
}
