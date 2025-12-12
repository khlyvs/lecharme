<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class SwitchLocale
{
    protected array $availableLocales = ['en', 'az', 'ru'];

    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route('locale');

        if ($locale && in_array($locale, $this->availableLocales)) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }

        return $next($request);
    }
}
