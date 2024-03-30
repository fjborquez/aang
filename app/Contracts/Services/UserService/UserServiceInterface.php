<?php

namespace App\Contracts\Services\UserService;

use App\Models\User;

interface UserServiceInterface
{
    public function create(array $data = []): User;
}
