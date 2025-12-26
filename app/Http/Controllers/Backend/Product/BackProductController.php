<?php

namespace App\Http\Controllers\Backend\Product;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Services\Backend\Product\ProductService;
use App\Http\Requests\Backend\Product\CreateProductRequest;
use App\Http\Requests\Backend\Product\FilterProductRequest;
use App\Http\Requests\Backend\Product\UpdateProductRequest;

class BackProductController extends Controller
{

   public function index(FilterProductRequest $request, ProductService $service)
    {
        $products = $service->paginate($request->filters());
        $categories = $service->getCategories();

        return view('manager.product.list_product', compact('products', 'categories'));
    }

    public function store(CreateProductRequest $request, ProductService $service)
    {
        $service->create($request->validated(), $request);

        return redirect()->route('product.view')
            ->with('success', 'Məhsul uğurla əlavə edildi');
    }

    public function update(UpdateProductRequest $request, Product $product, ProductService $service)
    {
        $service->update($product, $request->validated(), $request);

        return redirect()->route('product.view')
            ->with('success', 'Məhsul uğurla yeniləndi');
    }

}

