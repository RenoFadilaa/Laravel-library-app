<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_category_id' => [
                'required',
                'exists:categories,category_id',
            ],
            'book_publisher_id' => [
                'required',
                'exists:publishers,publisher_id',
            ],
            'book_shelf_id' => [
                'required',
                'exists:shelfs,shelf_id',
            ],
            'book_author_id' => [
                'required',
                'exists:authors,author_id',
            ],
            'book_name' => [
                'required',
                'string',
                'max:255',
            ],
            'book_isbn' => [
                'required',
                'string',
                'max:16',
            ],
            'book_stock' => [
                'required',
                'integer',
                'min:0',
            ],
            'book_description' => [
                'required',
                'string',
                'max:255',
            ],
            'book_img' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'book_category_id.required' => 'Category is required.',
            'book_category_id.exists' => 'Selected category is invalid.',
            'book_publisher_id.required' => 'Publisher is required.',
            'book_publisher_id.exists' => 'Selected publisher is invalid.',
            'book_shelf_id.required' => 'Shelf is required.',
            'book_shelf_id.exists' => 'Selected shelf is invalid.',
            'book_author_id.required' => 'Author is required.',
            'book_author_id.exists' => 'Selected author is invalid.',
            'book_name.required' => 'Book name is required.',
            'book_name.max' => 'Book name may not be greater than 255 characters.',
            'book_isbn.required' => 'ISBN is required.',
            'book_isbn.max' => 'ISBN may not be greater than 16 characters.',
            'book_stock.required' => 'Stock is required.',
            'book_stock.integer' => 'Stock must be an integer.',
            'book_stock.min' => 'Stock cannot be negative.',
            'book_description.required' => 'Description is required.',
            'book_description.max' => 'Description may not be greater than 255 characters.',
            'book_img.required' => 'Book image URL/string is required.',
            'book_img.max' => 'Book image string may not be greater than 255 characters.',
        ];
    }
}
