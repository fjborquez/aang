<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokenRequest;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use UnexpectedValueException;

class AccessTokenController extends Controller
{
    private $fields = ['password', 'email'];

    public function issueToken(TokenRequest $request)
    {
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

    public function checkToken(Request $request)
    {
        $publicKey = file_get_contents(storage_path('oauth-public.key'));

        if (! $publicKey) {
            return response()->noContent(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {
            JWT::decode($request->bearerToken(), new Key($publicKey, 'RS256'));
        } catch (SignatureInvalidException $exception) {
            return response()->noContent(Response::HTTP_UNAUTHORIZED);
        } catch (UnexpectedValueException $exception) {
            return response()->noContent(Response::HTTP_UNAUTHORIZED);
        } catch (Exception $exception) {
            return response()->noContent(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
