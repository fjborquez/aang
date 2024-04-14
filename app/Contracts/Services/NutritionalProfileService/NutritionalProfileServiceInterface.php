<?php

namespace App\Contracts\Services\NutritionalProfileService;

interface NutritionalProfileServiceInterface
{
    public function create(int $userId, array $data = []);
}
