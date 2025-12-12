<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'is_active',
        'position',
        'slug_az',
        'slug_en',
        'slug_ru',
        'name_az',
        'name_en',
        'name_ru',

    ];



    public function subcategories()
    {
      return  $this->hasMany(Subcategory::class);

    }

    public function getLocalizedNameAttribute()
    {
        $locale = app()->getLocale(); // 'az','en','ru'
        return $this->{"name_{$locale}"} ;
    }

     public function getLocalizedSlugAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"slug_{$locale}"};
    }

    protected static function booted()
{
    static::saved(function () {
        Cache::forget('menu.categories');
    });

    static::deleted(function () {
        Cache::forget('menu.categories');
    });
}

}

