<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ResidentService\ResidentServiceInterface;
use App\Exceptions\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ResidentController extends Controller
{
    public function __construct(private readonly ResidentServiceInterface $residentService) {}

    public function list(int $houseId)
    {
        return $this->residentService->getList($houseId);
    }

    public function delete(int $houseId, int $residentId)
    {
        try {
            $this->residentService->delete($houseId, $residentId);
            return response()->noContent(Response::HTTP_NO_CONTENT);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }

    }
}
