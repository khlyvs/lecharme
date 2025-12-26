<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{


    public function saved(Product $product): void
    {

        Cache::forget('home.products');

        // 🔥 Slug cache-lər
        Cache::forget("product.slug.{$product->slug_az}");
        Cache::forget("product.slug.{$product->slug_en}");
        Cache::forget("product.slug.{$product->slug_ru}");
    }
    public function created(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
      Cache::forget('home.products');
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
