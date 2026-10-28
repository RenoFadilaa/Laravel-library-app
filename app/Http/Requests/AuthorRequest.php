<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'author_name' => [
                'required',
                'string',
                'max:100'
            ],

            'author_description' => [
                'nullable',
                'string',
                'max:255'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'author_name.required' => 'Author name is required.',
            'author_name.max' => 'Author name may not be greater than 100 characters.',

            'author_description.max' => 'Description may not be greater than 255 characters.',
        ];
    }
}