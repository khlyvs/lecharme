<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Basket extends Model
{
    use HasFactory;

    /**
     * Mass assignment üçün icazəli sahələr
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'quantity',
    ];

    /**
     * Default dəyərlər
     */
    protected $attributes = [
        'quantity' => 1,
    ];

    /* ===================== RELATIONS ===================== */

    /**
     * Basket → User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Basket → Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /* ===================== SCOPES ===================== */

    /**
     * Login olmuş user üçün basket
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Guest (session) üçün basket
     */
    public function scopeForSession($query, string $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    /* ===================== HELPERS ===================== */

    /**
     * Sətir üzrə total qiymət
     */
    public function getTotalPriceAttribute(): float
    {
        return $this->product
            ? $this->product->price * $this->quantity
            : 0;
    }
}
