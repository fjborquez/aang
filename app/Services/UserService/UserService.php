<?php

namespace App\Services\UserService;

use App\Contracts\Services\UserService\UserServiceInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Database\Factories\UserFactory;

class UserService implements UserServiceInterface
{
    public function __construct(private readonly User $user)
    {
    }

    public function create(array $data = []): User
    {
        $user = $this->user->factory()->create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;
    }
}
