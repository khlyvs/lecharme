<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
 public function show($slug)
{
    $locale = App::getLocale(); // az, en, ru
    $slugColumn = 'slug_' . $locale;

    $category = Category::where($slugColumn, $slug)
        ->with('subcategories')
        ->first();



    return view('website.filter.filter', compact('category', ));
}

public function subShow($categorySlug, $subSlug)
{
    $locale = App::getLocale();
    $slugColumn = 'slug_' . $locale;

    $subcategory = Subcategory::where($slugColumn, $subSlug)
        ->with('category')
        ->first();

    $subcategories = Subcategory::where('category_id', $subcategory->category_id)
        ->get();

    return view('website.filter.filter', compact('subcategory', 'subcategories'));
}

}
