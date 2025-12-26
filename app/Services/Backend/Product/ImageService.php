<?php

namespace App\Services\Backend\Product;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\Backend\Product\ProductImageRepositoryInterface;


class ImageService
{
   public function __construct(
        protected ProductImageRepositoryInterface $repository
    ) {}

    public function store(Product $product, $request): void
    {
        $this->repository->store($product, $request);
    }

    public function update(Product $product, $request): void
    {
        $this->repository->update($product, $request);
    }

    public function delete(Product $product, array $ids): void
    {
        $this->repository->delete($product, $ids);
    }

    public function setMain(Product $product, ?int $id): void
    {
        $this->repository->setMain($product, $id);
    }

}
