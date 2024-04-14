<?php

namespace App\Contracts\Services\NutritionalRestrictionService;

interface NutritionalRestrictionServiceInterface
{
    function getList();

    function get(int $id): NutritionalRestriction
}
