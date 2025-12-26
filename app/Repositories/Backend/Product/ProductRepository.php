<?php

namespace App\Repositories\Backend\Product;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Interfaces\Backend\Product\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginate(array $filters): LengthAwarePaginator
    {
        return Product::with(['category', 'subcategory', 'images'])
            ->filter($filters)
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    public function getCategories(): Collection
    {
        return Cache::get('menu.categories') ?? collect();
    }
}
