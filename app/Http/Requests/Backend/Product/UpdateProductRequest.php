<?php

namespace App\Http\Requests\Backend\Product;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        $productId = $this->getProductId();

        return [
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',

            'name_az' => 'required|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',

            'slug_az' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug_az')->ignore($productId),
            ],
            'slug_ru' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug_ru')->ignore($productId),
            ],
            'slug_en' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug_en')->ignore($productId),
            ],

            'description_az' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'description_en' => 'nullable|string',

            'meta_title_az' => 'nullable|string|max:255',
            'meta_title_ru' => 'nullable|string|max:255',
            'meta_title_en' => 'nullable|string|max:255',

            'meta_description_az' => 'nullable|string|max:160',
            'meta_description_ru' => 'nullable|string|max:160',
            'meta_description_en' => 'nullable|string|max:160',

            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock'          => 'nullable|integer|min:0',

            'main_image_id'   => 'nullable|exists:images,id',
            'delete_images'   => 'nullable|array',
            'delete_images.*' => 'exists:images,id',
            'images.*'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
        ]);
    }

    /**
     * Get the product ID from route.
     */
    private function getProductId(): ?int
    {
        $product = $this->route('product');

        return $product?->id ?? $this->route('id');
    }

    public function messages(): array
{
    return [
        // Category / Subcategory
        'category_id.required' => 'Kateqoriya seçilməlidir.',
        'category_id.exists'   => 'Seçilən kateqoriya mövcud deyil.',

        'subcategory_id.exists' => 'Seçilən alt kateqoriya mövcud deyil.',

        // Names
        'name_az.required' => 'Məhsulun adı (AZ) mütləq doldurulmalıdır.',
        'name_az.string'   => 'Məhsulun adı (AZ) mətn formatında olmalıdır.',
        'name_az.max'      => 'Məhsulun adı (AZ) maksimum :max simvol ola bilər.',

        'name_ru.string' => 'Məhsulun adı (RU) mətn formatında olmalıdır.',
        'name_ru.max'    => 'Məhsulun adı (RU) maksimum :max simvol ola bilər.',

        'name_en.string' => 'Məhsulun adı (EN) mətn formatında olmalıdır.',
        'name_en.max'    => 'Məhsulun adı (EN) maksimum :max simvol ola bilər.',

        // Slugs
        'slug_az.unique' => 'Bu AZ slug artıq istifadə olunub.',
        'slug_az.max'    => 'AZ slug maksimum :max simvol ola bilər.',

        'slug_ru.unique' => 'Bu RU slug artıq istifadə olunub.',
        'slug_ru.max'    => 'RU slug maksimum :max simvol ola bilər.',

        'slug_en.unique' => 'Bu EN slug artıq istifadə olunub.',
        'slug_en.max'    => 'EN slug maksimum :max simvol ola bilər.',

        // Descriptions
        'description_az.string' => 'Açıqlama (AZ) mətn formatında olmalıdır.',
        'description_ru.string' => 'Açıqlama (RU) mətn formatında olmalıdır.',
        'description_en.string' => 'Açıqlama (EN) mətn formatında olmalıdır.',

        // Meta titles
        'meta_title_az.max' => 'Meta başlıq (AZ) maksimum :max simvol ola bilər.',
        'meta_title_ru.max' => 'Meta başlıq (RU) maksimum :max simvol ola bilər.',
        'meta_title_en.max' => 'Meta başlıq (EN) maksimum :max simvol ola bilər.',

        // Meta descriptions
        'meta_description_az.max' => 'Meta açıqlama (AZ) maksimum :max simvol ola bilər.',
        'meta_description_ru.max' => 'Meta açıqlama (RU) maksimum :max simvol ola bilər.',
        'meta_description_en.max' => 'Meta açıqlama (EN) maksimum :max simvol ola bilər.',

        // Price / Discount
        'price.required' => 'Qiymət sahəsi mütləq doldurulmalıdır.',
        'price.numeric'  => 'Qiymət yalnız rəqəm formatında olmalıdır.',
        'price.min'      => 'Qiymət 0-dan kiçik ola bilməz.',

        'discount_price.numeric' => 'Endirimli qiymət yalnız rəqəm formatında olmalıdır.',
        'discount_price.min'     => 'Endirimli qiymət 0-dan kiçik ola bilməz.',
        'discount_price.lt'      => 'Endirimli qiymət əsas qiymətdən kiçik olmalıdır.',

        // Stock
        'stock.integer' => 'Stok miqdarı yalnız tam ədəd ola bilər.',
        'stock.min'     => 'Stok miqdarı 0-dan az ola bilməz.',

        // Images
        'main_image_id.exists' => 'Seçilən əsas şəkil mövcud deyil.',

        'delete_images.array'     => 'Silinəcək şəkillər düzgün formatda deyil.',
        'delete_images.*.exists'  => 'Silinmək istənən şəkil mövcud deyil.',

        'images.*.image' => 'Yüklənən fayl şəkil formatında olmalıdır.',
        'images.*.mimes' => 'Şəkil yalnız jpg, jpeg, png və ya webp formatında ola bilər.',
        'images.*.max'   => 'Şəkil ölçüsü maksimum 2MB ola bilər.',

        // Status
        'is_active.boolean' => 'Aktivlik dəyəri yanlışdır.',
    ];
}
}
