<?php

namespace App\Contracts\Services\ResidentService;

interface ResidentServiceInterface
{
    public function getList(int $houseId);

    public function delete(int $houseId, int $residentId);
}
