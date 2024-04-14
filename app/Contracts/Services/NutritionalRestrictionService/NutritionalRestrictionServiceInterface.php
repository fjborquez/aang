<?php

namespace App\Contracts\Services\NutritionalRestrictionService;

use App\Models\NutritionalRestriction;

interface NutritionalRestrictionServiceInterface
{
    function getList();

    function get(int $id): NutritionalRestriction;
}
