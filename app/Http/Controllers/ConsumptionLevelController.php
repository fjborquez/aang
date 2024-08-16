<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ConsumptionLevelService\ConsumptionLevelServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class ConsumptionLevelController extends Controller
{
    public function __construct(private readonly ConsumptionLevelServiceInterface $consumptionLevelService) {}

    public function list()
    {
        return response()->json($this->consumptionLevelService->getList(), Response::HTTP_OK);
    }
}
