<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Slider extends Model
{
    // Əgər table adı sliders-dirsə, yazmağa ehtiyac yoxdur
    // protected $table = 'sliders';

    protected $fillable = [
        'slug_url_az',
        'slug_url_en',
        'slug_url_ru',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Cari dilə görə slug qaytarır
     */
    public function getSlugAttribute(): ?string
    {
        $locale = app()->getLocale();

        // fallback mexanizmi (əgər dil boşdursa)
        return $this->{'slug_url_' . $locale}
            ?? $this->slug_url_az;
    }

    /**
     * Aktiv slider-lar
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Slug auto-generate (istəyə bağlı, amma tövsiyə olunur)
     */
    protected static function booted()
    {
        static::creating(function ($slider) {

            if (!$slider->slug_url_az && $slider->slug_url_en) {
                $slider->slug_url_az = Str::slug($slider->slug_url_en);
            }

            if (!$slider->slug_url_en && $slider->slug_url_az) {
                $slider->slug_url_en = Str::slug($slider->slug_url_az);
            }

            if (!$slider->slug_url_ru && $slider->slug_url_az) {
                $slider->slug_url_ru = Str::slug($slider->slug_url_az);
            }
        });
    }
}
