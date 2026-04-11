<?php

namespace App\Contracts\Services\UserService;

use App\Models\User;

interface UserServiceInterface
{
    public function create(array $data = []): User;

    public function getList();

    public function update(int $id, array $data = []): void;

    public function get(int $id): User;

    public function enable(int $id): void;

    public function disable(int $id): void;

    public function createPasswordToken(array $data = []): string;

    public function resetPassword(array $data = []): void;
}
