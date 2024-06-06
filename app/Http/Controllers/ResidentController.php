<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ResidentService\ResidentServiceInterface;

class ResidentController extends Controller
{
    public function __construct(private readonly ResidentServiceInterface $residentService) {

    }

    public function list(int $houseId) {
        return $this->residentService->list($houseId);
    }
}
