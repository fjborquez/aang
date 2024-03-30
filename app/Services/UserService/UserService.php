<?php

namespace App\Services\UserService;

use App\Contracts\Services\UserService\UserServiceInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserService implements UserServiceInterface
{
    public function create(string $name, string $lastname, string $email, string $password): User
    {
        $user = new User;
        $user->name = $name;
        $user->lastname = $lastname;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        return $user;
    }
}
