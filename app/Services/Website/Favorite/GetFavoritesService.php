<?php

namespace App\Services\Website\Favorite;

use App\Models\Favorite;
use Illuminate\Support\Collection;

class GetFavoritesService
{
    protected ?Collection $cachedFavorites = null;

    public function getFavoritedProductIds(): Collection
    {
        // ✅ Eyni request-də 2-ci dəfə çağırılıbsa
        if ($this->cachedFavorites !== null) {
            return $this->cachedFavorites;
        }

        $query = Favorite::query();

        if (auth('web')->check()) {
            $query->where('user_id', auth('web')->id());
        } else {
            $query->where('session_id', session()->getId());
        }

        return $this->cachedFavorites = $query
            ->pluck('product_id')
            ->flip(); // O(1)
    }
}
