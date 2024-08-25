<?php

namespace App\Contracts\Services\BaseServiceInterface;

use App\Models\BaseModel;

interface BaseServiceInterface
{
    public function create(BaseModel $model);

    public function get(int $id): BaseModel;
}
