<?php

namespace App\Repositories\Website\Filter;

use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Interfaces\Website\Filter\FilterProductRepositoryInterface;

/**
 * Filter Product Repository
 * 
 * Handles database queries for product filtering
 * Implements caching and query optimization strategies
 * 
 * @package App\Repositories\Website\Filter
 */
class FilterProductRepository implements FilterProductRepositoryInterface
{
    /**
     * Get products by subcategory slug with filters
     *
     * @param string $slug Subcategory slug (az, en, or ru)
     * @param array<string, mixed> $filters Filter parameters
     * @return LengthAwarePaginator Paginated products collection
     */
    public function getBySubcategorySlug(string $slug, array $filters = []): LengthAwarePaginator
    {
        $subcategoryId = $this->resolveSubcategoryId($slug);

        if (!$subcategoryId) {
            return new Paginator([], 0, 12);
        }

        return $this->buildQuery($filters)
            ->where('subcategory_id', $subcategoryId)
            ->paginate($filters['per_page'] ?? 12);
    }

    /**
     * Get products by category ID with filters
     *
     * @param int $categoryId Category ID
     * @param array<string, mixed> $filters Filter parameters
     * @return LengthAwarePaginator Paginated products collection
     */
    public function getByCategoryId(int $categoryId, array $filters = []): LengthAwarePaginator
    {
        return $this->buildQuery($filters)
            ->where('category_id', $categoryId)
            ->when(!empty($filters['subcategories']), function ($q) use ($filters) {
                $q->whereIn('subcategory_id', $filters['subcategories']);
            })
            ->paginate($filters['per_page'] ?? 12);
    }

    /**
     * Build optimized query with all filters applied
     *
     * Applies:
     * - Price range filters (min/max)
     * - Discount filter
     * - Sorting options
     * - Selects only necessary columns
     * - Eager loads relationships
     *
     * @param array<string, mixed> $filters Filter parameters
     * @return Builder Eloquent query builder
     */
    private function buildQuery(array $filters = []): Builder
    {
        return Product::active()
            ->select([
                'id', 'category_id', 'subcategory_id',
                'name_az', 'name_en', 'name_ru',
                'slug_az', 'slug_en', 'slug_ru',
                'price', 'discount_price', 'created_at'
            ])
            ->with([
                'mainImage:id,product_id,image',
                'category:id,name_az,name_en,name_ru'
            ])
            // Qiymət filteri - minimum və maksimum
            // COALESCE istifadə edərək: discount_price varsa onu, yoxdursa price-ı götür
            ->when(isset($filters['min_price']) && $filters['min_price'] !== null, function ($q) use ($filters) {
                $q->whereRaw('COALESCE(discount_price, price) >= ?', [$filters['min_price']]);
            })
            ->when(isset($filters['max_price']) && $filters['max_price'] !== null, function ($q) use ($filters) {
                $q->whereRaw('COALESCE(discount_price, price) <= ?', [$filters['max_price']]);
            })
            // Endirimli məhsullar
            ->when(!empty($filters['has_discount']), function ($q) {
                $q->whereNotNull('discount_price')
                  ->whereColumn('discount_price', '<', 'price');
            })
            // Sıralama
            ->when(isset($filters['sort']), function ($q) use ($filters) {
                match ($filters['sort']) {
                    'price-low' => $q->orderByRaw('COALESCE(discount_price, price) ASC'),
                    'price-high' => $q->orderByRaw('COALESCE(discount_price, price) DESC'),
                    'newest' => $q->orderByDesc('created_at'),
                    default => $q->orderByDesc('id'),
                };
            }, function ($q) {
                $q->orderByDesc('id');
            });
    }

    /**
     * Resolve subcategory ID from slug (with caching)
     *
     * Caches result for 1 hour to improve performance
     * Supports multi-language slugs (az, en, ru)
     *
     * @param string $slug Subcategory slug
     * @return int|null Subcategory ID or null if not found
     */
    private function resolveSubcategoryId(string $slug): ?int
    {
        return Cache::remember("subcategory.id.$slug", 3600, function () use ($slug) {
            return Subcategory::where('slug_az', $slug)
                ->orWhere('slug_en', $slug)
                ->orWhere('slug_ru', $slug)
                ->value('id');
        });
    }
}
