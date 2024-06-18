<?php

namespace App\Http\Controllers;

use App\Contracts\Services\NutritionalRestrictionService\NutritionalRestrictionServiceInterface;

class NutritionalRestrictionController extends Controller
{
    public function __construct(private readonly NutritionalRestrictionServiceInterface $nutritionalRestrictionService) {}

    public function list()
    {
        return $this->nutritionalRestrictionService->getList();
    }
}
