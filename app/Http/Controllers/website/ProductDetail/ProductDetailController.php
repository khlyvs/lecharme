<?php

namespace App\Http\Controllers\Website\ProductDetail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Website\ProductDetail\ProductDetailService;


class ProductDetailController extends Controller
{

        public function __construct(
            protected ProductDetailService $productDetailService
        ) {}


   public function index(string $locale, string $slug)
{

    $product = $this->productDetailService
        ->getProductDetailBySlug($slug);
   
    if (!$product) {
        abort(404);
    }

    return view('website.product_detail.product', compact('product'));
}

}
