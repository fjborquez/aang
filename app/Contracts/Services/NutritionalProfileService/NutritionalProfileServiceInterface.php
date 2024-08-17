<?php

namespace App\Contracts\Services\NutritionalProfileService;

interface NutritionalProfileServiceInterface
{
    public function create(int $personId, array $data = []);

    public function get(int $id): array;

    public function update(int $personId, array $data = []);
}
