<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    public function permissions(){

        return $this->belongsToMany(Permission::class , 'admins_permissions')->using(AdminPermission::class);
    }

    public function hasPermission($permission){

        return $this->permissions->contains('permission_name' , $permission);
    }




}
