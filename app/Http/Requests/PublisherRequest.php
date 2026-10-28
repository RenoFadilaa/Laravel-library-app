<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublisherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'publisher_name' => [
                'required',
                'string',
                'max:150',
            ],
            'publisher_description' => [
                'nullable',
                'string',
                'max:150',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'publisher_name.required' => 'Publisher name is required.',
            'publisher_name.max' => 'Publisher name may not be greater than 150 characters.',
            'publisher_description.max' => 'Description may not be greater than 150 characters.',
        ];
    }
}
