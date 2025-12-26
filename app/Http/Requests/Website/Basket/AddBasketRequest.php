<?php

namespace App\Http\Requests\Website\Basket;

use Illuminate\Foundation\Http\FormRequest;

class AddBasketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product' => 'required|exists:products,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'product' => $this->route('product'),
        ]);
    }

    public function messages(): array
    {
        return [
            'product.required' => 'Məhsul tapılmadı',
            'product.exists'   => 'Məhsul mövcud deyil',
        ];
    }
}
