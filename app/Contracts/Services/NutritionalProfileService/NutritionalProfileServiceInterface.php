<?php

namespace App\Contracts\Services\NutritionalProfileService;

interface NutritionalProfileServiceInterface
{
    public function create(int $userId, array $data = []);

    public function get(int $id): array;
}
