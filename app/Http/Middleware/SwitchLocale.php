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
       $availableLocales = ['az', 'en', 'ru'];
        $segment = $request->segment(1);

        if (in_array($segment, $availableLocales)) {
            app()->setLocale($segment);
            session(['locale' => $segment]);
        } else {
            // Əgər URL-də səhv locale varsa → son istifadə olunanı saxla
            app()->setLocale(session('locale', 'az'));
        }
        return $next($request);
    }
}
