<?php

namespace App\Http\Requests\Management;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'to_kitchen' => ['required'],
            'concession_ids' => ['required', 'array'],
            'concession_ids.*' => ['required', 'integer', 'exists:concessions,id'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'concession_ids.required' => 'Please select at least one concession.',
            'concession_ids.array' => 'Concession IDs must be an array.',
            'concession_ids.*.required' => 'Concession ID is required.',
            'concession_ids.*.integer' => 'Concession ID must be an integer.',
            'concession_ids.*.exists' => 'Selected concession does not exist.',
        ];
    }
}
