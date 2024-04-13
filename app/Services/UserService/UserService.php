<?php

namespace App\Services\UserService;

use App\Contracts\Services\UserService\UserServiceInterface;
use App\Models\User;
use Exception;

class UserService implements UserServiceInterface
{
    public function __construct(private readonly User $user)
    {
    }

    public function create(array $data = []): User
    {
        $user = $this->user->factory()->create($data);
        return $user;
    }

    public function getList()
    {
        return $this->user->with('person')->get();
    }

    public function update(int $id, array $data = []): void
    {
        $user = $this->user->find($id);

        if ($user == null) {
            throw new Exception('User not found');
        }

        $user->update($data);
    }

    public function get(int $id): User
    {
        $user = $this->user->with('person')->find($id);

        if ($user == null) {
            throw new Exception('User not found');
        }

        return $user;
    }

    public function enable(int $id): void
    {
        $user = $this->user->find($id);

        if ($user == null) {
            throw new Exception('User not found');
        }

        if ($user->is_active) {
            throw new Exception('User already enabled');
        }

        $user->update([
            'is_active' => true,
        ]);
    }

    public function disable(int $id): void
    {
        $user = $this->user->find($id);

        if ($user == null) {
            throw new Exception('User not found');
        }

        if (!$user->is_active) {
            throw new Exception('User already disabled');
        }

        $user->update([
            'is_active' => false,
        ]);
    }
}
