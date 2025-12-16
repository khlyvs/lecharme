<?php

namespace App\Http\Controllers\website\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * CATEGORY PAGE
     */
    public function show(Request $request, string $locale, string $slug)
    {
        $category = $request->attributes->get('resolved_category');

        abort_if(!$category, 404);

        return view('website.filter.filter', [
            'category' => $category
        ]);
    }

    /**
     * SUBCATEGORY PAGE
     */
    public function subShow(Request $request, string $locale, string $categorySlug, string $subSlug)
    {
        $category = $request->attributes->get('resolved_category');
        $subcategory = $request->attributes->get('resolved_subcategory');

        abort_if(!$category || !$subcategory, 404);

        return view('website.filter.filter', [
            'category' => $category,
            'subcategory' => $subcategory
        ]);
    }
}
