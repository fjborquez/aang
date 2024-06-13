<?php

namespace App\Contracts\Services\NutritionalRestrictionService;

use App\Models\NutritionalRestriction;

interface NutritionalRestrictionServiceInterface
{
    public function getList();

    public function get(int $id): NutritionalRestriction;
}
