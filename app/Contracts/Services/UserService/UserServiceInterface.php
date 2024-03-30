<?php

namespace App\Contracts\Services\UserService;

use App\Models\User;

interface UserServiceInterface
{
    public function create(string $name, string $lastname, string $email, string $password): User;
}
