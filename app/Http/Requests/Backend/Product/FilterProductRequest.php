<?php

namespace App\Http\Requests\Backend\Product;

use Illuminate\Foundation\Http\FormRequest;

class FilterProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 🔍 Ada görə axtarış
            'q' => 'nullable|string|min:1|max:255',

            // 📂 Kateqoriya
            'category_id' => 'nullable|exists:categories,id',

            // 💰 Qiymət aralığı
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',

            // 🔄 Aktiv / Passiv
            'status' => 'nullable|in:0,1',
        ];
    }

    /**
     * Query üçün təmiz və təhlükəsiz filter data
     */
    public function filters(): array
    {
        return [
            'q'           => $this->input('q'),
            'category_id' => $this->input('category_id'),
            'min_price'   => $this->input('min_price'),
            'max_price'   => $this->input('max_price'),
            'status'      => $this->input('status'),
        ];
    }

    protected function prepareForValidation(): void
{
    if (
        $this->filled('min_price') &&
        $this->filled('max_price') &&
        $this->min_price > $this->max_price
    ) {
        $this->merge([
            'min_price' => $this->max_price,
            'max_price' => $this->min_price,
        ]);
    }
}
}
