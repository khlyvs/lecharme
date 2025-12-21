<?php

namespace App\Http\Requests\Backend\Slider;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
            'slug_url_az' => 'required|string|max:255',
            'slug_url_en' => 'nullable|string|max:255',
            'slug_url_ru' => 'nullable|string|max:255',

            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            'is_active' => 'nullable|boolean',
        ];
    }


     public function messages(): array
    {
        return [
            'slug_url_az.required' => 'AZ slug mütləqdir.',
            'image.required'       => 'Şəkil yükləmək mütləqdir.',
            'image.image'          => 'Yüklənən fayl şəkil olmalıdır.',
        ];
    }

     protected function prepareForValidation(): void
    {
        $this->merge([
            'slug_url_az' => $this->slug_url_az
                ? Str::slug($this->slug_url_az)
                : Str::slug($this->slug_url_en),

            'slug_url_en' => $this->slug_url_en
                ? Str::slug($this->slug_url_en)
                : Str::slug($this->slug_url_az),

            'slug_url_ru' => $this->slug_url_ru
                ? Str::slug($this->slug_url_ru)
                : Str::slug($this->slug_url_az),
        ]);
    }

}
