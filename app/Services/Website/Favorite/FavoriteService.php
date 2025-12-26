<?php

namespace App\Services\Website\Favorite;

use App\Models\Favorite;

class FavoriteService
{
    public function mergeGuestFavorites(string $guestSessionId): void
    {
        if (!auth('web')->check()) {
            return;
        }

        $userId = auth('web')->id();

        $guestFavorites = Favorite::where('session_id', $guestSessionId)->get();

        foreach ($guestFavorites as $fav) {
            Favorite::firstOrCreate([
                'user_id' => $userId,
                'product_id' => $fav->product_id,
            ]);
        }

        // köhnə guest favoritləri sil
        Favorite::where('session_id', $guestSessionId)->delete();
    }
}
