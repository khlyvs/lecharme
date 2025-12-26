<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SlugResolverService
{
    public function resolveCategory(string $slug, Collection $categories)
    {
        return $categories->first(fn ($cat) =>
            in_array($slug, [
                $cat->slug_az,
                $cat->slug_en,
                $cat->slug_ru
            ])
        );
    }

    public function resolveSubcategory(string $subSlug, Collection $categories): ?array
    {
        foreach ($categories as $category) {
            $sub = $category->subcategories->first(fn ($sub) =>
                in_array($subSlug, [
                    $sub->slug_az,
                    $sub->slug_en,
                    $sub->slug_ru
                ])
            );

            if ($sub) {
                return [$category, $sub];
            }
        }

        return null;
    }

    public function resolveProduct(string $slug): ?Product
{   
    return Cache::rememberForever(
        "product.slug.$slug", function () use ($slug) {
            return Product::where('slug_az', $slug)
                ->orWhere('slug_en', $slug)
                ->orWhere('slug_ru', $slug)
                ->first();
        }
    );
}
}
