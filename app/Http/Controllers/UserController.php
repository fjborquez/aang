<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Contracts\Services\UserService\UserServiceInterface;

class UserController extends Controller
{
    private $fields = ['name', 'lastname', 'password', 'email'];

    public function __construct(private readonly UserServiceInterface $userService)
    {
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $user = $this->userService->create($validated);
        return response()->json('User added', 201);
    }

    public function list()
    {
        return $this->userService->getList();
    }

    public function delete(int $id)
    {
        return $this->userService->delete($id);
    }

    public function update(int $id, StoreUserRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $user = $this->userService->update($id, $validated);
        return response()->json('User updated', 200);
    }
}
