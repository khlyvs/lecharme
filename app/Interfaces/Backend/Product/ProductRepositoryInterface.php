<?php

namespace App\Interfaces\Backend\Product;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function paginate(array $filters): LengthAwarePaginator;

    public function create(array $data): Product;

    public function update(Product $product, array $data): bool;

    public function getCategories(): Collection;
}
