<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserProfileRequest extends FormRequest
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
        return [
            'date_of_birth' => ['required', 'date_format:Y-m-d', 'before:tomorrow'],
            'is_vegetarian' => ['required'],
            'is_vegan' => ['required'],
            'is_celiac' => ['required'],
            'is_keto' => ['required'],
            'is_diabetic' => ['required'],
            'is_lactose' => ['required'],
            'is_gluten' => ['required']
        ];
    }
}
