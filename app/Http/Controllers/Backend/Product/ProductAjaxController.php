<?php

namespace App\Http\Controllers\Backend\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ProductAjaxController extends Controller
{
      public function subcategories($categoryId)
    {
        $categories = Cache::get('menu.categories');

        if (!$categories) {
            return response()->json([]);
        }

        $category = $categories->firstWhere('id', (int) $categoryId);

        return response()->json(
            $category?->subcategories ?? []
        );
    }
}
