<?php

namespace App\Http\Requests\Auth;

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
            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'email', 'max:255', 'unique:users,email'],

            'password' => [
                'required',
                'string',
                'min:8',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Ad Soyad daxil edilməlidir.',
            'email.required' => 'Email daxil edilməlidir.',
            'email.email' => 'Düzgün email formatı daxil edin.',
            'email.unique' => 'Bu email artıq qeydiyyatdan keçib.',
            'password.required' => 'Şifrə daxil edilməlidir.',
            'password.min' => 'Şifrə minimum 8 simvol olmalıdır.',
        ];
    }
}
