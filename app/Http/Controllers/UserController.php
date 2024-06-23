<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserService\UserServiceInterface;
use App\Exceptions\OperationNotAllowedException;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Requests\UserRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $fields = ['password', 'email', 'person_id'];

    public function __construct(private readonly UserServiceInterface $userService) {}

    public function store(UserRequest $request)
    {
        $validated = $request->safe()->only($this->fields);
        $user = $this->userService->create($validated);

        return response()->noContent(Response::HTTP_CREATED)
            ->header('Location', url('/api/user/'.$user->id));
    }

    public function list()
    {
        return $this->userService->getList();
    }

    public function update(int $id, UserRequest $request)
    {
        $validated = $request->safe()->only($this->fields);

        try {
            $this->userService->update($id, $validated);

            return response()->noContent(Response::HTTP_NO_CONTENT);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }
    }

    public function get(int $id)
    {
        try {
            return response()->json($this->userService->get($id), Response::HTTP_OK);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }
    }

    public function enable(int $id)
    {
        try {
            $this->userService->enable($id);

            return response()->noContent(Response::HTTP_NO_CONTENT);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        } catch (OperationNotAllowedException $exception) {
            return response()->noContent(Response::HTTP_BAD_REQUEST);
        }
    }

    public function disable(int $id)
    {
        try {
            $this->userService->disable($id);

            return response()->noContent(Response::HTTP_NO_CONTENT);
        } catch (ResourceNotFoundException $exception) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        } catch (OperationNotAllowedException $exception) {
            return response()->noContent(Response::HTTP_BAD_REQUEST);
        }
    }
}
