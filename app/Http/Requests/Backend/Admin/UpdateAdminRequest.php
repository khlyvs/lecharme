<?php

namespace App\Http\Requests\Backend\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'status' => 'boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ];
    }

    public function validatedData(): array
    {
        return [
            'name' => $this->name,
            'status' => $this->has('status') ? 1 : 0,
        ];
    }

     public function messages(): array
    {
        return [
            // NAME
            'name.required' => 'Ad və soyad mütləq daxil edilməlidir.',
            'name.string'   => 'Ad və soyad mətn formatında olmalıdır.',
            'name.max'      => 'Ad və soyad maksimum 255 simvol ola bilər.',

            // PASSWORD
            'password.string' => 'Şifrə mətn formatında olmalıdır.',
            'password.min'    => 'Şifrə minimum 6 simvol olmalıdır.',

            // STATUS
            'status.boolean' => 'Status düzgün formatda göndərilməyib.',

            // PERMISSIONS
            'permissions.array' => 'İcazələr düzgün formatda deyil.',
            'permissions.*.exists' => 'Seçilmiş icazələrdən biri mövcud deyil.',
        ];
    }
}
