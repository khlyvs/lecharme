<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'product_id',
        'image',
        'is_main',
        'position',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'position' => 'integer',
    ];

    /**
     * Image belongs to Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
