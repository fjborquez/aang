<?php

namespace App\Services\UserService;

use App\Contracts\Services\UserService\UserServiceInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Database\Factories\UserFactory;
use Exception;

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

    public function getList()
    {
        return $this->user->with('userProfile')->get();
    }

    public function delete(int $id): void
    {
        $user = $this->user->find($id);
        $userProfile = $user->userProfile;

        if ($userProfile != null) {
            $userProfile->delete();
        }

        $user->delete();
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
        $user = $this->user->find($id);

        if ($user == null) {
            throw new Exception('User not found');
        }

        return $user;
    }
}
