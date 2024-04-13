<?php

namespace App\Providers;

use App\Contracts\Services\PersonService\PersonServiceInterface;
use App\Services\PersonService\PersonService;
use Illuminate\Support\ServiceProvider;

class PersonServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->app->bind(
            PersonServiceInterface::class,
            PersonService::class
        );
    }
}
