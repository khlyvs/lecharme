<?php

namespace App\Http\Requests\Backend\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6',
            'status' => 'boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ];
    }

    public function messages(): array
    {
        return [
            // NAME
            'name.required' => 'Ad və soyad mütləq daxil edilməlidir.',
            'name.string'   => 'Ad və soyad mətn formatında olmalıdır.',
            'name.max'      => 'Ad və soyad maksimum 255 simvol ola bilər.',

            // EMAIL
            'email.required' => 'E-mail mütləq daxil edilməlidir.',
            'email.email'    => 'E-mail formatı düzgün deyil.',
            'email.unique'   => 'Bu e-mail artıq istifadə olunur.',

            // PASSWORD
            'password.required' => 'Şifrə mütləq daxil edilməlidir.',
            'password.string'   => 'Şifrə mətn formatında olmalıdır.',
            'password.min'      => 'Şifrə minimum 6 simvol olmalıdır.',

            // STATUS
            'status.boolean' => 'Status düzgün formatda göndərilməyib.',

            // PERMISSIONS
            'permissions.array' => 'İcazələr düzgün formatda deyil.',
            'permissions.*.exists' => 'Seçilmiş icazələrdən biri mövcud deyil.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'ad və soyad',
            'email' => 'e-mail',
            'password' => 'şifrə',
            'status' => 'status',
            'permissions' => 'icazələr',
        ];
    }
}
