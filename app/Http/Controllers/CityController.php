<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CityService\CityServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    public function __construct(private readonly CityServiceInterface $cityServiceInterface) {}

    public function list()
    {
        return response()->json($this->cityServiceInterface->getList(), Response::HTTP_OK);
    }
}
