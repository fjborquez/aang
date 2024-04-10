<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user_id = null;

        if(count(Request::segments()) == 3)
        {
            $user_id = Request::segments()[2];
        }

        return [
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
            'email' => ['required', 'email:rfc,dns', 'unique:users,email,' . $user_id],
            'person_id' => ['required', 'numeric','exists:persons,id'],
        ];
    }
}
