<?php

namespace App\Http\Requests\Backend\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
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

            /* ================= RELATIONS ================= */
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',

            /* ================= NAME ================= */
            'name_az' => 'required|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',

            /* ================= SLUG ================= */
            'slug_az' => 'nullable|string|max:255|unique:products,slug_az',
            'slug_ru' => 'nullable|string|max:255|unique:products,slug_ru',
            'slug_en' => 'nullable|string|max:255|unique:products,slug_en',

            /* ================= DESCRIPTION ================= */
            'description_az' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'description_en' => 'nullable|string',

            /* ================= META ================= */
            'meta_title_az' => 'nullable|string|max:255',
            'meta_title_ru' => 'nullable|string|max:255',
            'meta_title_en' => 'nullable|string|max:255',

            'meta_description_az' => 'nullable|string|max:160',
            'meta_description_ru' => 'nullable|string|max:160',
            'meta_description_en' => 'nullable|string|max:160',

            /* ================= PRICE / STOCK ================= */
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock'          => 'nullable|integer|min:0',

            /* ================= IMAGES ================= */
            'images'   => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

            /* ================= STATUS ================= */
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Prepare data before validation
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
        ]);
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Kateqoriya seçilməlidir',

            'name_az.required' => 'Məhsul adı (AZ) mütləqdir',

            'slug_az.required' => 'Slug (AZ) mütləqdir',
            'slug_az.unique'   => 'Bu AZ slug artıq mövcuddur',

            'slug_ru.unique'   => 'Bu RU slug artıq mövcuddur',
            'slug_en.unique'   => 'Bu EN slug artıq mövcuddur',

            'price.required'   => 'Qiymət mütləqdir',
            'price.numeric'    => 'Qiymət rəqəm olmalıdır',

            'discount_price.lt' => 'Endirimli qiymət əsas qiymətdən kiçik olmalıdır',

            'images.*.image' => 'Yüklənən fayl şəkil olmalıdır',
            'images.*.max'   => 'Şəkil maksimum 2MB ola bilər',
        ];
    }
}
