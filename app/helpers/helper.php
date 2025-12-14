<?php

if (!function_exists('locale_url')) {
    function locale_url(string $locale): string
{
    $segments = request()->segments();

    // Əgər URL locale ilə başlayırsa → yalnız onu dəyiş
    if (isset($segments[0]) && in_array($segments[0], ['az','en','ru'])) {
        $segments[0] = $locale;
        return url(implode('/', $segments));
    }

    // Əgər locale YOXDURSA → yalnız /{locale} et
    return url('/' . $locale);
}

}
