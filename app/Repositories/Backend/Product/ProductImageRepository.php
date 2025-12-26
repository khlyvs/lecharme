<?php

namespace App\Repositories\Backend\Product;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\Backend\Product\ProductImageRepositoryInterface;

class ProductImageRepository implements ProductImageRepositoryInterface
{
    private string $disk = 'public';
    private string $directory = 'products';

    public function store(Product $product, $request): void
    {
        if (!$request->hasFile('images')) return;

        $hasMain  = $product->images()->where('is_main', true)->exists();
        $position = (int) $product->images()->max('position');

        foreach ($request->file('images') as $index => $image) {

            $fileName = 'product_' . $product->id . '_' . Str::uuid() . '.' . $image->getClientOriginalExtension();

            $image->storeAs($this->directory, $fileName, $this->disk);

            $product->images()->create([
                'image'    => $fileName,
                'is_main'  => !$hasMain && $index === 0,
                'position' => ++$position,
            ]);
        }
    }

    public function update(Product $product, $request): void
    {
        if (!$request->hasFile('images')) return;

        $hasMain  = $product->images()->where('is_main', true)->exists();
        $position = (int) $product->images()->max('position');

        foreach ($request->file('images') as $index => $image) {

            $fileName = 'product_' . $product->id . '_' . Str::uuid() . '.' . $image->getClientOriginalExtension();

            $image->storeAs($this->directory, $fileName, $this->disk);

            $product->images()->create([
                'image'    => $fileName,
                'is_main'  => !$hasMain && $index === 0,
                'position' => ++$position,
            ]);
        }
    }

    public function delete(Product $product, array $ids): void
    {
        if (empty($ids)) return;

        DB::transaction(function () use ($product, $ids) {

            $images = $product->images()->whereIn('id', $ids)->get();
            $wasMainDeleted = $images->contains('is_main', true);

            foreach ($images as $image) {
                $path = $this->directory . '/' . $image->image;

                if (Storage::disk($this->disk)->exists($path)) {
                    Storage::disk($this->disk)->delete($path);
                }

                $image->delete();
            }

            if ($wasMainDeleted) {
                $product->images()->update(['is_main' => false]);

                $next = $product->images()->orderBy('position')->first();
                if ($next) {
                    $next->update(['is_main' => true]);
                }
            }
        });
    }

    public function setMain(Product $product, ?int $id): void
    {
        if (!$id) return;

        $currentMainId = $product->images()
            ->where('is_main', true)
            ->value('id');

        if ((int) $currentMainId === (int) $id) return;

        DB::transaction(function () use ($product, $id) {

            $image = $product->images()->where('id', $id)->first();
            if (!$image) return;

            $product->images()
                ->where('is_main', true)
                ->update(['is_main' => false]);

            $image->update(['is_main' => true]);
        });
    }
}
