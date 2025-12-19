<?php

namespace App\Http\Controllers\Backend\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Category\StoreCategoryRequest;
use App\Http\Requests\Backend\Category\UpdateCategoryRequest;
use Illuminate\Support\Facades\Cache;

class BackCategoryController extends Controller
{


   public function index()
{
    $categoryMenus = Category::all();

    return view('manager.categoryies.category_list', compact('categoryMenus'));
}


    public function store(StoreCategoryRequest $request)
        {
            $data = $request->validated();

            $data['position'] = $data['position'] ?? 0 ;

            $data['is_active'] = $request->has('is_active') ? 1 : 0;

            Category::create($data);

            return redirect()->route('category.view')->with('success' ,'Kateqoriya Uğurla Əlavə Edildi !');

        }

    public function update(UpdateCategoryRequest $request , $id){

        $category = Category::findOrFail($id);
        $data = $request->validated();

        $data['position'] =$data['position'] ?? 0;

        $data['is_active'] =$data['is_active'] ? 1 : 0 ;

        $category->update($data);
        return redirect()->route('category.view')->with('success', 'Kateqoriya uğurla yeniləndi.');

    }


}
