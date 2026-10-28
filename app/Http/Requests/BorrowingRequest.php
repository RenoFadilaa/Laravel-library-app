<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BorrowingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'borrowing_notes' => [
                'nullable',
                'string',
            ],
            'items' => [
                'required',
                'array',
                'min:1',
            ],
            'items.*.book_id' => [
                'required',
                'exists:books,book_id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'You must select at least one book to borrow.',
            'items.array' => 'Invalid book selection format.',
            'items.min' => 'You must borrow at least one book.',
            'items.*.book_id.required' => 'Book selection is required.',
            'items.*.book_id.exists' => 'Selected book is invalid.',
            'items.*.quantity.required' => 'Quantity is required.',
            'items.*.quantity.integer' => 'Quantity must be a number.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
        ];
    }
}
