<?php

namespace App\Services\NutritionalRestrictionService;

use App\Contracts\Services\NutritionalRestrictionService\NutritionalRestrictionServiceInterface;
use App\Models\NutritionalRestriction;
use Illuminate\Database\Eloquent\Collection;

class NutritionalRestrictionService implements NutritionalRestrictionServiceInterface
{
    public function __construct(private readonly NutritionalRestriction $nutritionalRestriction) {}

    public function getList(): Collection
    {
        return $this->nutritionalRestriction->all();
    }

    public function get(int $id): NutritionalRestriction
    {
        return $this->nutritionalRestriction->find($id);
    }
}
