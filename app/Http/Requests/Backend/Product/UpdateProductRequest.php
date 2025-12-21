<?php

namespace App\Http\Requests\Backend\Product;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product')->id ?? $this->route('id');

        return [

            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',

            'name_az' => 'required|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',

            'slug_az' => [
                'nullable','string','max:255',
                Rule::unique('products', 'slug_az')->ignore($productId),
            ],
            'slug_ru' => [
                'nullable','string','max:255',
                Rule::unique('products', 'slug_ru')->ignore($productId),
            ],
            'slug_en' => [
                'nullable','string','max:255',
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
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'is_active' => 'nullable|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
        ]);
    }
}
