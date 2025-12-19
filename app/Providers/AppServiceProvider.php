<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\View\Composers\CatalogComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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
