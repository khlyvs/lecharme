<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['permission_name'];

    public function admins(){

        return $this->belongsToMany(Admin::class , 'admins_permissions')->using(AdminPermission::class);
    }





}
