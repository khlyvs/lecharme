<?php

namespace App\Http\Controllers\Backend\Product;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Backend\Product\CreateProductRequest;
use App\Http\Requests\Backend\Product\UpdateProductRequest;

class BackProductController extends Controller
{
   public function index()
    {
    $products = Product::query()
        ->with(['category', 'subcategory', 'mainImage'])
        ->orderByDesc('id')
        ->paginate(20);
        // dd($products);
    // Mövcud cache-dən oxuyuruq
    $categories = Cache::get('menu.categories') ?? collect();

    return view( 'manager.product.list_product', compact('products', 'categories') );




    }

   public function store(CreateProductRequest $request)
{
    DB::beginTransaction();

    try {
        $data = $request->validated();

                        // Functionu Asagda yazmisam.
        $data = $this->prepareSlugs($data);

        // Defaults
        $data['stock'] ??= 0;

        // Create product
        $product = Product::create($data);

        // Images
        $this->storeImages($product, $request);

        DB::commit();

        return redirect()
            ->route('product.view')
            ->with('success', 'Məhsul uğurla əlavə edildi');

    } catch (\Throwable $e) {
        DB::rollBack();

        report($e);

        return back()
            ->withErrors('Xəta baş verdi, yenidən cəhd edin')
            ->withInput();
    }
}

  public function update(UpdateProductRequest $request, Product $product)
{   dd($request->all());

    DB::beginTransaction();

    try {
        $data = $request->validated();
        $data = $this->prepareSlugs($data);
        $data['stock'] ??= 0;

        $product->update($data);

        /* =======================
           1️⃣ ŞƏKİL SİLMƏ
        ======================= */
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $product->images()->find($imageId);

                if ($image) {
                    // storage-dan sil
                    if (Storage::disk('public')->exists($image->image)) {
                        \Storage::disk('public')->delete($image->image);
                    }

                    $image->delete();
                }
            }
        }

        /* =======================
           2️⃣ ƏSAS ŞƏKİL SEÇİMİ
        ======================= */
        if ($request->filled('main_image_id')) {
            // əvvəl hamısını söndür
            $product->images()->update(['is_main' => false]);

            // seçiləni əsas et
            $product->images()
                ->where('id', $request->main_image_id)
                ->update(['is_main' => true]);
        }

        /* =======================
           3️⃣ YENİ ŞƏKİLLƏR
        ======================= */
        if ($request->hasFile('images')) {
            $this->storeImages($product, $request);
        }

        DB::commit();

        return redirect()
            ->route('product.view')
            ->with('success', 'Məhsul uğurla yeniləndi');

    } catch (\Throwable $e) {
        DB::rollBack();
        report($e);

        return back()
            ->withErrors('Yeniləmə zamanı xəta baş verdi')
            ->withInput();
    }
}


private function prepareSlugs(array $data): array
{
    // AZ (məcburi)
    $data['slug_az'] = $this->makeSlug(
        $data['slug_az'] ?? null,
        $data['name_az'],
        'slug_az'
    );

    // RU
    if (!empty($data['name_ru'])) {
        $data['slug_ru'] = $this->makeSlug(
            $data['slug_ru'] ?? null,
            $data['name_ru'],
            'slug_ru'
        );
    }

    // EN
    if (!empty($data['name_en'])) {
        $data['slug_en'] = $this->makeSlug(
            $data['slug_en'] ?? null,
            $data['name_en'],
            'slug_en'
        );
    }

    return $data;
}

private function makeSlug(?string $slug, string $source, string $column): string
{
    $baseSlug = $slug ? Str::slug($slug) : Str::slug($source);
    $finalSlug = $baseSlug;
    $counter = 1;

    while (Product::where($column, $finalSlug)->exists()) {
        $finalSlug = $baseSlug . '-' . $counter++;
    }

    return $finalSlug;
}

private function storeImages(Product $product, $request): void
{
    if (!$request->hasFile('images')) {
        return;
    }

    foreach ($request->file('images') as $index => $image) {
        $path = $image->store('products', 'public');

        $product->images()->create([
            'image'    => $path,
            'is_main'  => $index === 0,
            'position' => $index,
        ]);
    }
}

}
