<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Filter Request Validation
 * 
 * Validates filter parameters for product filtering
 * Used in category and subcategory pages
 */
class FilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Public filter, everyone can use
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Price range filters
            'min_price' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999',
            ],
            'max_price' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999',
            ],

            // Subcategory filters
            'subcategories' => [
                'nullable',
                'array',
            ],
            'subcategories.*' => [
                'required',
                'integer',
                'exists:subcategories,id',
            ],

            // Discount filter
            'has_discount' => [
                'nullable',
                'boolean',
            ],

            // Sort options
            'sort' => [
                'nullable',
                'string',
                'in:default,price-low,price-high,newest',
            ],

            // Pagination
            'page' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'min_price.numeric' => 'Minimum qiymət rəqəm olmalıdır',
            'min_price.min' => 'Minimum qiymət 0-dan kiçik ola bilməz',
            'max_price.numeric' => 'Maksimum qiymət rəqəm olmalıdır',
            'max_price.min' => 'Maksimum qiymət 0-dan kiçik ola bilməz',
            'max_price.gte' => 'Maksimum qiymət minimum qiymətdən böyük və ya bərabər olmalıdır',
            'subcategories.array' => 'Alt kateqoriyalar massiv formatında olmalıdır',
            'subcategories.*.exists' => 'Seçilmiş alt kateqoriya mövcud deyil',
            'sort.in' => 'Sıralama seçimi düzgün deyil',
            'page.integer' => 'Səhifə nömrəsi tam ədəd olmalıdır',
            'per_page.max' => 'Səhifədə maksimum 100 məhsul göstərilə bilər',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'min_price' => 'minimum qiymət',
            'max_price' => 'maksimum qiymət',
            'subcategories' => 'alt kateqoriyalar',
            'has_discount' => 'endirimli məhsullar',
            'sort' => 'sıralama',
            'page' => 'səhifə',
            'per_page' => 'səhifədə məhsul sayı',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert string 'true'/'false' to boolean
        if ($this->has('has_discount')) {
            $this->merge([
                'has_discount' => filter_var($this->has_discount, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false,
            ]);
        }

        // Ensure subcategories is array
        if ($this->has('subcategories') && !is_array($this->subcategories)) {
            $this->merge([
                'subcategories' => is_string($this->subcategories) 
                    ? explode(',', $this->subcategories) 
                    : [],
            ]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $minPrice = $this->input('min_price');
            $maxPrice = $this->input('max_price');

            // max_price must be >= min_price (if both are provided)
            if ($minPrice !== null && $maxPrice !== null && $maxPrice < $minPrice) {
                $validator->errors()->add(
                    'max_price',
                    'Maksimum qiymət minimum qiymətdən böyük və ya bərabər olmalıdır'
                );
            }
        });
    }
}
