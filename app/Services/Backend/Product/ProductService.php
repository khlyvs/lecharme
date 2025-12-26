<?php
namespace App\Services\Backend\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Interfaces\Backend\Product\ProductRepositoryInterface;


class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected ImageService $imageService,
        protected SlugService $slugService
    ) {}



    public function paginate(array $filters)
    {
        return $this->productRepository->paginate($filters);
    }

    public function getCategories()
    {
        return $this->productRepository->getCategories();
    }

    public function create(array $data, $request): void
    {
        DB::transaction(function () use ($data, $request) {
            $data = $this->slugService->prepare($data);
            $data['stock'] ??= 0;

            $product = $this->productRepository->create($data);
            $this->imageService->store($product, $request);
        });
    }

    public function update(Product $product, array $data, $request): void
    {

        DB::transaction(function () use ($product, $data, $request) {
            $data = $this->slugService->prepare($data, $product);

            $this->productRepository->update($product, $data);

            $this->imageService->delete($product, $request->delete_images ?? []);
            $this->imageService->setMain($product, $request->main_image_id);
            $this->imageService->update($product, $request);
        });
    }
}




