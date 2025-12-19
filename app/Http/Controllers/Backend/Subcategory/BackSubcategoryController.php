<?php

namespace App\Http\Controllers\Backend\Subcategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Subcategory\StoreSubcategoryRequest;
use App\Http\Requests\Backend\Subcategory\UpdateSubcategoryRequest;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class BackSubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->orderBy('position')->get();
        $categories = Category::orderBy('position')->get();

        return view('manager.categoryies.subcategory_list', compact('subcategories', 'categories'));
    }

    public function store(StoreSubcategoryRequest $request)
    {
        $data = $request->validated();

        // Slug-lar Form Request-də prepareForValidation() ilə hazırlanıb
        // Position default 0
        $data['position'] = $data['position'] ?? 0;

        // Status
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        Subcategory::create($data);

        Cache::forget('menu.categories');

        return redirect()->route('subcategory.view')->with('success', 'Subcategory uğurla əlavə edildi.');
    }

    public function update(UpdateSubcategoryRequest $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);

        $data = $request->validated();

        // Slug-lar Form Request-də prepareForValidation() ilə hazırlanıb
        // Position default 0
        $data['position'] = $data['position'] ?? 0;

        // Status
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $subcategory->update($data);

        return redirect()->route('subcategory.view')->with('success', 'Subcategory uğurla yeniləndi.');
    }

    public function destroy($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();


        return redirect()->route('subcategory.view')->with('success', 'Subcategory uğurla silindi.');
    }
}



