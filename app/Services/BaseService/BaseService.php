<?php

namespace App\Services\BaseService;

use App\Contracts\Services\BaseServiceInterface\BaseServiceInterface;
use App\Models\BaseModel;
use App\Traits\BaseModelTrait;

abstract class BaseService implements BaseServiceInterface
{
    use BaseModelTrait;

    public function __construct(private readonly BaseModel $model) {}

    public function create(BaseModel $model): void
    {
        $this->validate($model);
        $model->save();
    }

    /**
     * @return mixed
     */
    public function getBaseModel(): BaseModel
    {
        return $this->model;
    }
}
