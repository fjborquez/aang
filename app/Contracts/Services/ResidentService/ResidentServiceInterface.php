<?php

namespace App\Contracts\Services\ResidentService;

interface ResidentServiceInterface
{
    public function list(int $houseId);
}
