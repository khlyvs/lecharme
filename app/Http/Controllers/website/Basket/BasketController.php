<?php

namespace App\Http\Controllers\Website\Basket;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Basket\AddBasketRequest;
use App\Services\Website\Basket\BasketService;

class BasketController extends Controller
{


    public function __construct(private BasketService $basketService)  { }


    public function add(AddBasketRequest $request, int $product)
    {
        $quantity = (int) $request->input('quantity', 1);
        $quantity = max(1, min($quantity, 10)); // 1-10 arası sınırla
        
        $result = $this->basketService->add($product, $quantity);

        return response()->json($result);
    }


}
