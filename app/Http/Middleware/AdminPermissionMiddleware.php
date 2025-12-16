<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminPermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        /** @var Admin|null $admin */
        $admin = auth('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.auth');
        }

        // ❗ PERMISSION YOXDURSA → 403
        if (!$admin->hasPermission($permission)) {
            abort(403);
        }
        return $next($request);
    }
}
