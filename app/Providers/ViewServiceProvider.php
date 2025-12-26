<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\Website\Favorite\GetFavoritesService;
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       View::composer('website.*', function ($view) {

        $favorites = app(GetFavoritesService::class)
            ->getFavoritedProductIds();

        $view->with('favorites', $favorites);
    });
    }
}
