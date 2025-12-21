<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        // Relations
        'category_id',
        'subcategory_id',

        // Names (multi-language)
        'name_az',
        'name_en',
        'name_ru',

        // Slugs (multi-language)
        'slug_az',
        'slug_en',
        'slug_ru',

        // Descriptions (multi-language)
        'description_az',
        'description_en',
        'description_ru',

        // SEO (multi-language)
        'meta_title_az',
        'meta_title_en',
        'meta_title_ru',

        'meta_description_az',
        'meta_description_en',
        'meta_description_ru',

        // Pricing
        'price',
        'discount_price',

        // Stock & status
        'stock',
        'is_active',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'price'          => 'float',
        'discount_price' => 'float',
        'stock'          => 'integer',
        'is_active'      => 'boolean',
    ];

    /* =========================
     | Relationships
     |========================= */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class)->withDefault();
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function mainImage()
    {
        return $this->hasOne(Image::class)
            ->where('is_main', true)
            ->latest();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getHasDiscountAttribute()
    {
    return $this->discount_price && $this->discount_price < $this->price;
    }

    /* =========================
     | SEO Accessors
     |========================= */

    public function getSeoTitleAttribute()
    {
        $locale = app()->getLocale();

        return $this->{'meta_title_'.$locale}
            ?? $this->{'name_'.$locale};
    }

    public function getSeoDescriptionAttribute()
    {
        $locale = app()->getLocale();

        return $this->{'meta_description_'.$locale}
            ?? str($this->{'description_'.$locale})->limit(160);
    }
}
