<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AdminPermission extends Pivot
{
     protected $table = 'admins_permissions';

     protected $fillable = [
        'admin_id',
        'permission_id',
    ];
}
