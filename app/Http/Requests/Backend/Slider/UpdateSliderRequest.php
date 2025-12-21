<?php

namespace App\Http\Requests\Backend\Slider;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateSliderRequest extends FormRequest
{
    /**
     * Authorization
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'slug_url_az' => 'nullable|string|max:255',
            'slug_url_en' => 'nullable|string|max:255',
            'slug_url_ru' => 'nullable|string|max:255',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'is_active' => 'nullable|boolean',
        ];
    }


     public function messages(): array
    {
        return [
            'slug_url_az.string' => 'AZ slug düzgün formatda deyil.',
            'slug_url_az.max'    => 'AZ slug maksimum 255 simvol ola bilər.',

            'slug_url_en.string' => 'EN slug düzgün formatda deyil.',
            'slug_url_en.max'    => 'EN slug maksimum 255 simvol ola bilər.',

            'slug_url_ru.string' => 'RU slug düzgün formatda deyil.',
            'slug_url_ru.max'    => 'RU slug maksimum 255 simvol ola bilər.',

            'image.image' => 'Yüklənən fayl şəkil olmalıdır.',
            'image.mimes' => 'Şəkil formatı jpg, jpeg, png və ya webp olmalıdır.',
            'image.max'   => 'Şəkilin ölçüsü maksimum 2MB ola bilər.',
        ];
    }


    /**
     * Slug normalize (auto-slug)
     */
    
}
