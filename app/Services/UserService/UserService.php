<?php

namespace App\Services\UserService;

use App\Contracts\Services\UserService\UserServiceInterface;
use App\Exceptions\OperationNotAllowedException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserService implements UserServiceInterface
{
    public function __construct(private readonly User $user) {}

    public function create(array $data = []): User
    {
        $user = User::create($data);
        $user->assignRole('user');

        return $user;
    }

    public function getList()
    {
        return QueryBuilder::for(User::class)
            ->with('person', 'person.nutritionalProfile', 'person.houses')
            ->allowedFilters(
                AllowedFilter::exact('email')
            )
            ->get();
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

    public function createPasswordToken(array $data = []): string
    {
        $user = User::where('email', $data['email'])->first();

        if ($user == null) {
            throw new ResourceNotFoundException('User not found');
        }

        return Password::createToken($user);
    }

    public function resetPassword(array $data = []): void
    {
        $user = User::where('email', $data['email'])->first();

        if ($user == null) {
            throw new ResourceNotFoundException('User not found');
        }

        Password::reset([
            'email' => $data['email'],
            'token' => $data['token'],
            'password' => $data['password'],
            'password_confirmation' => $data['password'],
        ], function (User $toChange, string $password) {
            $toChange->forceFill([
                'password' => Hash::make($password),
            ]);
            $toChange->save();
        });
    }
}
