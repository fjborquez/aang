<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserService\UserServiceInterface;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    private $fields = ['password', 'email', 'person_id'];

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

    public function update(int $id, StoreUserRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $this->userService->update($id, $validated);
        return response()->json('User updated', 200);
    }

    public function get(int $id)
    {
        return $this->userService->get($id);
    }

    public function enable(int $id)
    {
        return $this->userService->enable($id);
    }

    public function disable(int $id)
    {
        return $this->userService->disable($id);
    }
}
