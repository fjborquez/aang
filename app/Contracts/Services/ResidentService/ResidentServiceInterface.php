<?php

namespace App\Contracts\Services\ResidentService;

interface ResidentServiceInterface
{
    public function getList(int $houseId);
}
