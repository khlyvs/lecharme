<?php

namespace App\Http\Controllers\Website\Favorite;

use App\Models\Product;
use App\Models\Favorite;
use App\Http\Controllers\Controller;
use App\Services\Website\Favorite\GetFavoritesService;
use App\Services\Website\Favorite\GetFavoriteProductService;

class FavoriteController extends Controller
{
    public function addfavorite(Product $product)
    {
        if (auth('web')->check()) {
            $where = [
                'user_id' => auth('web')->id(),
                'product_id' => $product->id,
            ];
        } else {
            $where = [
                'session_id' => session()->getId(),
                'product_id' => $product->id,
            ];
        }

        Favorite::where($where)->exists()
            ? Favorite::where($where)->delete()
            : Favorite::create($where);

        return response()->json(['success' => true]);
    }


    public function index(){
        $products = app(GetFavoriteProductService::class)->handle();
        // dd($products);

        return view('website.favorites.favorite' , compact('products'));
    }
}
