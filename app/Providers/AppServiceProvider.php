<?php

namespace App\Providers;

use App\Models\Product;
use App\Observers\ProductObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use App\View\Composers\CatalogComposer;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Website\Home\HomeInterface;

use App\Repositories\Website\Home\HomeRepository;
use App\Repositories\Backend\Product\ProductRepository;
use App\Repositories\Backend\Product\ProductImageRepository;
use App\Interfaces\Backend\Product\ProductRepositoryInterface;
use App\Interfaces\Website\ProductDetail\ProductDetailInterface;
use App\Interfaces\Backend\Product\ProductImageRepositoryInterface;
use App\Repositories\Website\ProductDetail\ProductDetailRepository;

use App\Interfaces\Website\Basket\BasketRepositoryInterface;
use App\Interfaces\Website\Filter\FilterProductRepositoryInterface;
use App\Repositories\Website\Basket\BasketRepository;
use App\Repositories\Website\Filter\FilterProductRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            HomeInterface::class,
            HomeRepository::class
        );

         $this->app->bind(
            ProductImageRepositoryInterface::class,
            ProductImageRepository::class
        );

         $this->app->bind(
            ProductDetailInterface::class,
            ProductDetailRepository::class
        );

         $this->app->bind(
        BasketRepositoryInterface::class,
        BasketRepository::class
    );

           $this->app->bind(
            FilterProductRepositoryInterface::class,
            FilterProductRepository::class
        );
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Cacheni silmek ucun observer
        Product::observe(ProductObserver::class);

        /**
         * Admin permission blade directive
         *
         * Usage:
         * @adminPermission('category.view')
         *      ...
         * @endadminPermission
         */
        Blade::if('adminPermission', function (string $permission) {
            $admin = auth('admin')->user();

            return $admin && $admin->hasPermission($permission);
        });

        /**
         * Catalog menu composer
         */
        View::composer('components.catalog-menu', CatalogComposer::class);

        /**
         * Helper dosyaları
         */
        require_once app_path('helpers/locale.php');
        require_once app_path('helpers/helper.php');



    }
}
