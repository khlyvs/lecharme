<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;

class AdminPermissionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $admin = auth('admin')->user();

    if (!$admin) {
        return redirect()->route('backend.login');
    }

    $routeName = $request->route()?->getName();

    if (!$routeName) {
        abort(403);
    }

    // backend.dashboard.view → dashboard.view
    // backend.dashboard      → dashboard.view
    $base = str_replace('backend.', '', $routeName);

    if (!str_contains($base, '.')) {
        $permission = $base . '.view';
    } else {
        $permission = $base;
    }

    if (!$admin->hasPermission($permission)) {
        abort(403);
    }


          return $next($request);

    }
}
