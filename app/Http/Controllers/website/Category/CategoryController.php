<?php

namespace App\Http\Controllers\website\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Services\Website\Filter\FilterProductService;

/**
 * Category Controller
 * 
 * Handles category and subcategory page requests
 * Supports both regular and AJAX requests for filtering
 */
class CategoryController extends Controller
{
    public function __construct(
        private FilterProductService $productFilterService
    ) {}

    /**
     * Display category page with products
     *
     * @param FilterRequest $request Validated filter request
     * @param string $locale Current locale (az, en, ru)
     * @param string $slug Category slug
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function show(FilterRequest $request, string $locale, string $slug)
    {
        $category = $request->attributes->get('resolved_category');

        abort_if(!$category, 404);

        $filters = $this->productFilterService->extractFilters($request);
        $products = $this->productFilterService->getByCategoryId($category->id, $filters);

        // AJAX request üçün partial view qaytar
        if ($request->ajax()) {
            return response()->json([
                'html' => view('website.filter.partials.products', compact('products'))->render(),
                'count' => $products->total(),
                'pagination' => $products->links()->toHtml(),
            ]);
        }

        return view('website.filter.filter', [
            'category' => $category,
            'products' => $products,
            'filters'  => $filters,
        ]);
    }

    /**
     * Display subcategory page with products
     *
     * @param FilterRequest $request Validated filter request
     * @param string $locale Current locale (az, en, ru)
     * @param string $categorySlug Parent category slug
     * @param string $subSlug Subcategory slug
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function subShow(
        FilterRequest $request,
        string $locale,
        string $categorySlug,
        string $subSlug
    ) {
        $category    = $request->attributes->get('resolved_category');
        $subcategory = $request->attributes->get('resolved_subcategory');

        abort_if(!$category || !$subcategory, 404);

        $filters = $this->productFilterService->extractFilters($request);
        $products = $this->productFilterService->getBySubcategorySlug($subSlug, $filters);

        // AJAX request üçün partial view qaytar
        if ($request->ajax()) {
            return response()->json([
                'html' => view('website.filter.partials.products', compact('products'))->render(),
                'count' => $products->total(),
                'pagination' => $products->links()->toHtml(),
            ]);
        }

        return view('website.filter.filter', [
            'category'    => $category,
            'subcategory' => $subcategory,
            'products'    => $products,
            'filters'     => $filters,
        ]);
    }
}
