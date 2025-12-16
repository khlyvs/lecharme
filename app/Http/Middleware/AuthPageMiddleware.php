<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthPageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if ($request->is('admin/*')) {
            return $next($request);
        }
         if (Auth::guard('web')->check()) {
            $locale = session('locale', app()->getLocale()) ?: 'az';

            return redirect()->route('dashboard', [
                'locale' => $locale
            ])->with('info', 'Artıq daxil olmusunuz!');
        }

        return $next($request);
    }
}
