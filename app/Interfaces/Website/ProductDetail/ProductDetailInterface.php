<?php
namespace App\Interfaces\Website\ProductDetail;

use App\Models\Product;




interface ProductDetailInterface
{
     public function getProductDetailBySlug(string $slug): ?Product;

}
