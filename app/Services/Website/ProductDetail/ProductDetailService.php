<?php

namespace App\Services\Website\ProductDetail;

use App\Models\Product;
use App\Interfaces\Website\ProductDetail\ProductDetailInterface;



class ProductDetailService
{

    public function __construct( private  ProductDetailInterface $productDetailRepository){
    }

   public function getProductDetailBySlug(string $slug): ?Product
{
    return cache()->remember(
        "product.detail.by_slug.$slug",
        3600,
        fn () => $this->productDetailRepository->getProductDetailBySlug($slug)
    );
}


}

