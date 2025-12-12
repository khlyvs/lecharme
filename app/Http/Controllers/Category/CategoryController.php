<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
   public function show($slug)
{
    $category = Category::where("slug_az", $slug)
        ->orWhere("slug_en", $slug)
        ->orWhere("slug_ru", $slug)
        ->with("subcategories")
        ->firstOrFail();

    return view("website.category", compact("category"));
}

public function subShow($categorySlug, $subSlug)
{
    $subcategory = Subcategory::where(function ($q) use ($subSlug) {
        $q->where("slug_az", $subSlug)
          ->orWhere("slug_en", $subSlug)
          ->orWhere("slug_ru", $subSlug);
    })
    ->with("category")
    ->firstOrFail();

    return view("website.subcategory", compact("subcategory"));
}

}
