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
    return $this->hasMany(Image::class)
        ->orderByDesc('is_main')
        ->orderBy('position');
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

     public function getLocalizedNameAttribute()
    {
        $locale = app()->getLocale(); // 'az','en','ru'
        return $this->{"name_{$locale}"} ;
    }
    public function getLocalizedDescriptionAttribute()
    {
        $locale = app()->getLocale(); // 'az','en','ru'
        return $this->{"description_{$locale}"} ;
    }

     public function getLocalizedSlugAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"slug_{$locale}"};
    }

    public function getPriceFormattedAttribute(): string
    {
        return number_format($this->price, 0, '.', ' ') ;
    }

    public function getDiscountPriceFormattedAttribute(): string
    {
        return number_format($this->discount_price, 0, '.', ' ') ;
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

    public function scopeFilter($query, array $filters)
{
    return $query

        // 🔍 Ada görə axtarış
        ->when(!empty($filters['q']), function ($q) use ($filters) {
            $search = $filters['q'];

            $q->where(function ($qq) use ($search) {
                $qq->where('name_az', 'like', "%{$search}%")
                   ->orWhere('name_en', 'like', "%{$search}%")
                   ->orWhere('name_ru', 'like', "%{$search}%");
            });
        })

        // 📂 Kateqoriya
        ->when(!empty($filters['category_id']),
            fn ($q) => $q->where('category_id', $filters['category_id'])
        )

        // 💰 Min qiymət
        ->when($filters['min_price'] !== null,
            fn ($q) => $q->where('price', '>=', $filters['min_price'])
        )

        // 💰 Max qiymət
        ->when($filters['max_price'] !== null,
            fn ($q) => $q->where('price', '<=', $filters['max_price'])
        )

        // 🔄 Aktiv / Passiv (0 da işləsin!)
        ->when(array_key_exists('status', $filters) && $filters['status'] !== null,
            fn ($q) => $q->where('is_active', (int) $filters['status'])
        );
}

        // Favotritlər əlaqəsi
        public function favorites()
        {
            return $this->hasMany(Favorite::class);
        }

        public function baskets()
        {
            return $this->hasMany(Basket::class);
        }
}
