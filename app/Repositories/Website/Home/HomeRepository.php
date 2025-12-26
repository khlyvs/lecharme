<?php

namespace App\Repositories\Website\Home;

use App\Interfaces\Website\Home\HomeInterface;
use App\Models\Product;
use Illuminate\Support\Collection;

class HomeRepository implements HomeInterface{


     public function getProducts(): Collection
    {
        return Product::with(['category', 'subcategory', 'images' ,'mainImage'])
            ->active()
            ->orderByDesc('id')
            ->limit(10)
            ->get();
    }


}
