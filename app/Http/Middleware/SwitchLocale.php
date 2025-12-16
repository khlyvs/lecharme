<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SwitchLocale
{
    protected array $availableLocales = ['az', 'en', 'ru'];

    public function handle(Request $request, Closure $next)
    {
        $segment = $request->segment(1);

        if (in_array($segment, $this->availableLocales)) {
            App::setLocale($segment);
            session(['locale' => $segment]);
        } else {
            App::setLocale(session('locale', 'az'));
        }

        return $next($request);
    }
}
