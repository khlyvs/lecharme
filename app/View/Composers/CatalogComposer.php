<?php
namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CatalogComposer
{
    protected $cacheKey = 'menu.categories';

    public function compose(View $view)
    {
        $categories = Cache::rememberForever($this->cacheKey, function () {
            return Category::with(['subcategories' => function($q) {
                $q->orderBy('position')->where('is_active',1);
            }])->orderBy('position')->where('is_active',1)->get();
        });

        $view->with('menuCategories', $categories);
    }


}
