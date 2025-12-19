<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Request-level permission cache
     */
    protected ?array $permissionCache = null;

    /**
     * Admin → Permissions (many-to-many)
     */
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'admins_permissions'
        );
    }

    /**
     * Check if admin has a permission
     */
    public function hasPermission(string $permission): bool
    {
        // 🔹 Request daxilində artıq oxunubsa → RAM-dan istifadə et
        if ($this->permissionCache === null) {
            $this->permissionCache = Cache::remember(
                'admin_permissions_' . $this->id,
                now()->addHour(),
                fn () => $this->permissions()
                    ->pluck('permission_name')
                    ->toArray()
            );
        }

        return in_array($permission, $this->permissionCache, true);
    }

    /**
     * Clear permission cache (permission dəyişəndə çağır)
     */
    public function clearPermissionCache(): void
    {
        Cache::forget('admin_permissions_' . $this->id);
        $this->permissionCache = null;
    }
}
