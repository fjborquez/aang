<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * Array of required attributes.
     *
     * @var array
     */
    protected $requiredAttributes = [];

    public function getRequiredAttributes(): array
    {
        return $this->requiredAttributes;
    }
}
