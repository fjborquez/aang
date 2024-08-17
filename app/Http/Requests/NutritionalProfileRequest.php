<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NutritionalProfileRequest extends FormRequest
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
            'nutritionalProfile' => ['required', 'array'],
            'nutritionalProfile.*.product_category_id' => ['required', 'numeric', 'gt:0'],
            'nutritionalProfile.*.product_category_name' => ['string'],
            'nutritionalProfile.*.consumption_level_id' => ['required', 'exists:App\Models\ConsumptionLevel,id']
        ];
    }

    public function messages(): array
    {
        return [
            'nutritionalProfile.*.product_category_id.required' => 'Product category information is required',
            'nutritionalProfile.*.consumption_level_id.required' => 'Consumption level information is required',
            'nutritionalProfile.*.consumption_level_id.exists' => 'Consumption level information is incorrect or does not exist'
        ];
    }
}
