<?php

use App\Providers\AppServiceProvider;
use App\Providers\CityServiceProvider;
use App\Providers\ConsumptionLevelServiceProvider;
use App\Providers\HousePersonServiceProvider;
use App\Providers\HouseServiceProvider;
use App\Providers\NutritionalRestrictionServiceProvider;
use App\Providers\PersonServiceProvider;
use App\Providers\ResidentServiceProvider;
use App\Providers\UserServiceProvider;

return [
    AppServiceProvider::class,
    ConsumptionLevelServiceProvider::class,
    HousePersonServiceProvider::class,
    HouseServiceProvider::class,
    NutritionalRestrictionServiceProvider::class,
    PersonServiceProvider::class,
    ResidentServiceProvider::class,
    UserServiceProvider::class,
    CityServiceProvider::class,
];
