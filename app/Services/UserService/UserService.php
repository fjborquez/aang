<?php

namespace App\Services\UserService;

use App\Contracts\Services\UserService\UserServiceInterface;
use App\Exceptions\OperationNotAllowedException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\User;

class UserService implements UserServiceInterface
{
    public function __construct(private readonly User $user) {}

    public function create(array $data = []): User
    {
        $user = $this->user->factory()->create($data);

        return $user;
    }

    public function getList()
    {
        return $this->user->with('person')->with('person.nutritionalProfile')->with('person.houses')->get();
    }

    public function update(int $id, array $data = []): void
    {
        $user = $this->user->find($id);

        if ($user == null) {
            throw new ResourceNotFoundException('User not found');
        }

        $user->update($data);
    }

    public function get(int $id): User
    {
        $user = $this->user->with('person')->with('person.nutritionalProfile')->with('person.nutritionalProfile.consumptionLevel')->with('person.houses')
            ->with('person.houses.city')->with('person.houses.persons')->find($id);

        if ($user == null) {
            throw new ResourceNotFoundException('User not found');
        }

        return $user;
    }

    public function enable(int $id): void
    {
        $user = $this->user->find($id);

        if ($user == null) {
            throw new ResourceNotFoundException('User not found');
        }

        if ($user->is_active) {
            throw new OperationNotAllowedException('User already enabled');
        }

        $user->update([
            'is_active' => true,
        ]);
    }

    public function disable(int $id): void
    {
        $user = $this->user->find($id);

        if ($user == null) {
            throw new ResourceNotFoundException('User not found');
        }

        if (! $user->is_active) {
            throw new OperationNotAllowedException('User already disabled');
        }

        $user->update([
            'is_active' => false,
        ]);
    }
}
