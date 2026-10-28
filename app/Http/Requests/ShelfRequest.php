<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShelfRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shelf_name' => [
                'required',
                'string',
                'max:150',
            ],
            'shelf_position' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'shelf_name.required' => 'Shelf name is required.',
            'shelf_name.max' => 'Shelf name may not be greater than 150 characters.',
            'shelf_position.required' => 'Shelf position is required.',
            'shelf_position.max' => 'Position may not be greater than 255 characters.',
        ];
    }
}
