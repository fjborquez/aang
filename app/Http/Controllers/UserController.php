<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Contracts\Services\UserService\UserServiceInterface;

class UserController extends Controller
{
    public function __construct(private readonly UserServiceInterface $userService)
    {
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->safe()->only(['name', 'lastname', 'password', 'email']);
        $user = $this->userService->create($validated);
        return response()->json('User added', 201);
    }
}
