<?php

namespace App\Http\Requests\Backend\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Models\Category;

class StoreCategoryRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name_az' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_ru' => 'nullable|string|max:255',

            'slug_az' => 'nullable|string|max:255',
            'slug_en' => 'nullable|string|max:255',
            'slug_ru' => 'nullable|string|max:255',

            'position' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $slugAz = $this->slug_az ?: Str::slug($this->name_az);
            $slugEn = $this->slug_en ?: ($this->name_en ? Str::slug($this->name_en) : null);
            $slugRu = $this->slug_ru ?: ($this->name_ru ? Str::slug($this->name_ru) : null);

            if (Category::where('slug_az', $slugAz)->exists()) {
                $validator->errors()->add('slug_az', 'Bu slug (Azərbaycan) artıq istifadə olunur.');
            }

            if ($slugEn && Category::where('slug_en', $slugEn)->exists()) {
                $validator->errors()->add('slug_en', 'Bu slug (English) artıq istifadə olunur.');
            }

            if ($slugRu && Category::where('slug_ru', $slugRu)->exists()) {
                $validator->errors()->add('slug_ru', 'Bu slug (Русский) artıq istifadə olunur.');
            }
        });
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'name_az.required' => 'Ad (Azərbaycan) mütləqdir.',
            'name_az.string'   => 'Ad (Azərbaycan) mətn formatında olmalıdır.',
            'name_az.max'      => 'Ad (Azərbaycan) maksimum 255 simvol ola bilər.',

            'name_en.string' => 'Ad (English) mətn formatında olmalıdır.',
            'name_en.max'    => 'Ad (English) maksimum 255 simvol ola bilər.',

            'name_ru.string' => 'Ad (Русский) mətn formatında olmalıdır.',
            'name_ru.max'    => 'Ad (Русский) maksimum 255 simvol ola bilər.',

            'slug_az.string' => 'Slug (Azərbaycan) mətn formatında olmalıdır.',
            'slug_az.max'    => 'Slug (Azərbaycan) maksimum 255 simvol ola bilər.',

            'slug_en.string' => 'Slug (English) mətn formatında olmalıdır.',
            'slug_en.max'    => 'Slug (English) maksimum 255 simvol ola bilər.',

            'slug_ru.string' => 'Slug (Русский) mətn formatında olmalıdır.',
            'slug_ru.max'    => 'Slug (Русский) maksimum 255 simvol ola bilər.',

            'position.integer' => 'Position rəqəm olmalıdır.',
            'position.min'     => 'Position minimum 0 ola bilər.',

            'is_active.boolean' => 'Status düzgün formatda deyil.',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'name_az' => 'ad (Azərbaycan)',
            'name_en' => 'ad (English)',
            'name_ru' => 'ad (Русский)',
            'slug_az' => 'slug (Azərbaycan)',
            'slug_en' => 'slug (English)',
            'slug_ru' => 'slug (Русский)',
            'position' => 'position',
            'is_active' => 'status',
        ];
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug_az' => $this->slug_az ?: Str::slug($this->name_az ?? ''),
            'slug_en' => $this->slug_en ?: ($this->name_en ? Str::slug($this->name_en) : null),
            'slug_ru' => $this->slug_ru ?: ($this->name_ru ? Str::slug($this->name_ru) : null),
        ]);
    }
}
