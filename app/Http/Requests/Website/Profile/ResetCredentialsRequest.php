<?php

namespace App\Http\Requests\Website\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ResetCredentialsRequest extends FormRequest
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
        'current_password' => ['required', 'current_password'],
        'password' => [
            'required',
            'confirmed',
            'min:8',
            'different:current_password',
        ],
    ];

    }


      public function messages(): array
    {
        return [
            'current_password.required' => 'Cari şifrəni daxil edin.',
            'current_password.current_password' => 'Cari şifrə düzgün deyil.',

            'password.required' => 'Yeni şifrəni daxil edin.',
            'password.confirmed' => 'Yeni şifrə təsdiqi uyğun deyil.',
            'password.min' => 'Yeni şifrə ən az 8 simvoldan ibarət olmalıdır.',
            'password.different' => 'Yeni şifrə cari şifrə ilə eyni ola bilməz.',
        ];
    }


}
