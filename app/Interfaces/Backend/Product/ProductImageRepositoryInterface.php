<?php

namespace App\Interfaces\Backend\Product;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductImageRepositoryInterface
{
    public function store(Product $product, $request): void;

    public function update(Product $product, $request): void;

    public function delete(Product $product, array $ids): void;

    public function setMain(Product $product, ?int $id): void;
}
