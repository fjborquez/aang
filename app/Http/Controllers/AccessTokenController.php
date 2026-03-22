<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokenRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AccessTokenController extends Controller
{
    private $fields = ['password', 'email'];

    public function issueToken(TokenRequest $request) {
        $validated = $request->safe()->only($this->fields);

        $user = User::where('email', $validated['email'])->first();

        if ($user && Hash::check($validated['password'], $user->password)
                && $user->is_active) {

            $token = $user->createToken(
                'authToken',
                $user->getRoleNames()->toArray()
            );

            return response()->json([
                'access_token' => $token->accessToken,
                'token_type' => 'Bearer',
                'expires_in' => $token->expiresIn,
            ]);
        }

        return response()->noContent(Response::HTTP_UNAUTHORIZED);
    }
}
