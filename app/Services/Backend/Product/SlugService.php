<?php
namespace  App\Services\Backend\Product;

use App\Models\Product;
use Illuminate\Support\Str;

class Slugservice {



      public function prepare(array $data, ?Product $product = null): array
    {
        foreach (['az', 'ru', 'en'] as $locale) {
            $name = "name_$locale";
            $slug = "slug_$locale";

            if (empty($data[$name])) continue;

            if (empty($data[$slug]) || ($product && $product->$slug !== $data[$slug])) {
                $data[$slug] = $this->unique(
                    $data[$slug] ?? $data[$name],
                    $slug,
                    $product?->id
                );
            }
        }

        return $data;
    }

    private function unique(string $value, string $column, ?int $excludeId): string
    {
        $base = Str::slug($value);
        $slug = $base;
        $i = 1;

        while (
            Product::where($column, $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }





}
