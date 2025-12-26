<?php

namespace App\Services\Website\Favorite;

use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Support\Collection;

class GetFavoriteProductService
{


    public function handle(): Collection
    {
        // 1️⃣ Favori product ID-ləri alırıq
        $productIds = app(GetFavoritesService::class)
            ->getFavoritedProductIds()
            ->keys();

        // 2️⃣ Favori yoxdursa boş collection qaytarırıq
        if ($productIds->isEmpty()) {
            return collect();
        }

        // 3️⃣ Favori məhsulları çəkirik
        return Product::with(['images', 'category' , 'mainImage'])
            ->whereIn('id', $productIds)
            ->where('is_active', true)
            ->get();
    }
}
