<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|max:150',
            'last_name' => 'required|max:150',
            'username' => 'required|max:150',
            'email' => 'required|email|max:150',
            'password' => 'required|max:150',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute wajib diisi.',
            'email' => 'Format email tidak valid.',
            'max' => ':attribute maksimal 150 karakter.',
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}