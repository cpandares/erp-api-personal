<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaxesRequest extends FormRequest
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
            'name' => 'unique|required|string|max:255',
            'description' => 'string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'created_at' => 'date',
            'updated_at' => 'date',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'name.string' => 'The name must be a string.',            
            'percentage.required' => 'The percentage field is required.',
            'percentage.numeric' => 'The percentage must be a number.',
            'percentage.min' => 'The percentage must be at least 0.',
            'percentage.max' => 'The percentage may not be greater than 100.',
        ];
    }
    public function attributes(): array
    {
        return [
            'name' => 'tax name',
            'description' => 'tax description',
            'percentage' => 'tax percentage',
            'is_active' => 'tax active status',
            'created_at' => 'creation date',
        ];
    }

}
