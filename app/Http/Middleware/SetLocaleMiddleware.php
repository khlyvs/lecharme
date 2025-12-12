<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocaleMiddleware
{
    protected array $availableLocales = ['en','az','ru'];

    public function handle($request, Closure $next)
    {
        // 1) Route prefix-dən locale götür (ən önəmli)
        $routeLocale = $request->route('locale');

        // 2) Session-dakı əvvəlki dil
        $sessionLocale = Session::get('locale');

        // 3) Default dil
        $default = config('app.locale');

        // Hansını tətbiq edək?
        if ($routeLocale && in_array($routeLocale, $this->availableLocales)) {
            $locale = $routeLocale;
        }
        elseif ($sessionLocale && in_array($sessionLocale, $this->availableLocales)) {
            $locale = $sessionLocale;
        }
        else {
            $locale = $default;
        }

        // Session-a yaz
        Session::put('locale', $locale);

        // Dili tətbiq et
        App::setLocale($locale);

        return $next($request);
    }
}
