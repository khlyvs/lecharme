<?php

namespace App\Repositories\Website\ProductDetail;

use App\Models\Product;
use App\Interfaces\Website\ProductDetail\ProductDetailInterface;

class ProductDetailRepository implements ProductDetailInterface
{
    public function getProductDetailBySlug(string $slug): ?Product
    {
        return Product::with('images', 'category', 'subcategory')
            ->where('slug_az', $slug)
            ->orWhere('slug_en', $slug)
            ->orWhere('slug_ru', $slug)
            ->first();
    }
}


