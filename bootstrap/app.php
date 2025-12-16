<?php

use App\Http\Middleware\AdminPermissionMiddleware;
use Illuminate\Foundation\Application;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\AuthPageMiddleware;
use App\Http\Middleware\NormalizeLocalizedSlug;
use App\Http\Middleware\SetLocaleMiddleware;
use App\Http\Middleware\SwitchLocale;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.user' => AuthMiddleware::class,
            'auth.page' => AuthPageMiddleware::class,
            'setlocale' => SetLocaleMiddleware::class,
            'switch.locale' => SwitchLocale::class,
            'normalize.slug'=>NormalizeLocalizedSlug::class,
             'admin.permission' => AdminPermissionMiddleware::class,
        ]);

        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            SetLocaleMiddleware::class,
            NormalizeLocalizedSlug::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
