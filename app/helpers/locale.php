<?php

if (!function_exists('locale_url')) {
    /**
     * URL-dəki locale-u dəyişir və slug'ları çevirir (sadece category route'larında)
     */
    function locale_url(string $locale): string
{
    $route = request()->route();
    $segments = request()->segments();

    // locale dəyiş
    $segments[0] = $locale;

    if (!$route) {
        return url(implode('/', $segments));
    }

    // CATEGORY
    if ($category = request()->route('category')) {
        $segments[1] = $category->{"slug_$locale"};
    }

    // SUBCATEGORY
    if ($subcategory = request()->route('subcategory')) {
        $segments[2] = $subcategory->{"slug_$locale"};
    }

    return url(implode('/', $segments));
}
}

if (!function_exists('locale_route')) {
    /**
     * Route yaradarkən avtomatik locale əlavə edir
     */
    function locale_route(string $name, array $params = []): string
    {
        $locale = session('locale', app()->getLocale()) ?: 'az';
        return route($name, array_merge(['locale' => $locale], $params));
    }
}

if (!function_exists('current_locale')) {
    /**
     * Cari locale-u qaytarır
     */
    function current_locale(): string
    {
        return session('locale', app()->getLocale()) ?: 'az';
    }
}

