<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\SlugResolverService;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class NormalizeLocalizedSlug
{
   public function handle(Request $request, Closure $next)
{



    $route = $request->route();
    if (!$route) return $next($request);

    $locale = app()->getLocale();
    
    // Cache yoxdursa, yenidən yüklə
    $categories = Cache::get('menu.categories');
    if (!$categories) {
        $categories = Category::with([
            'subcategories' => function ($q) {
                $q->orderBy('position')
                  ->where('is_active', 1);
            }
        ])
        ->orderBy('position')
        ->where('is_active', 1)
        ->get();
        
        // Cache-ə yaz
        Cache::forever('menu.categories', $categories);
    }

    $resolver = app(SlugResolverService::class);

    // CATEGORY
    if ($route->getName() === 'category.show') {
        $slug = $route->parameter('slug');
        $category = $resolver->resolveCategory($slug, $categories);

        if ($category) {
            $correct = $category->{"slug_$locale"};

            if ($slug !== $correct) {
                return redirect()->route(
                    'category.show',
                    ['locale' => $locale, 'slug' => $correct],
                    301
                );
            }

            $request->attributes->set('resolved_category', $category);
        }
    }

    // SUBCATEGORY
    if ($route->getName() === 'subcategory.show') {
        $catSlug = $route->parameter('categorySlug');
        $subSlug = $route->parameter('subSlug');

        $result = $resolver->resolveSubcategory($subSlug, $categories);

        if ($result) {
            [$category, $sub] = $result;

            $correctCat = $category->{"slug_$locale"};
            $correctSub = $sub->{"slug_$locale"};

            if ($catSlug !== $correctCat || $subSlug !== $correctSub) {
                return redirect()->route(
                    'subcategory.show',
                    [
                        'locale' => $locale,
                        'categorySlug' => $correctCat,
                        'subSlug' => $correctSub
                    ],
                    301
                );
            }

            $request->attributes->set('resolved_category', $category);
            $request->attributes->set('resolved_subcategory', $sub);
        } else {
            // Subcategory tapılmadı, 404 qaytar
            abort(404);
        }
    }

    return $next($request);
}
}
