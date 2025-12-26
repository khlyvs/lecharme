<?php

namespace App\Repositories\Website\Basket;

use App\Models\Basket;
use Illuminate\Support\Collection;
use App\Interfaces\Website\Basket\BasketRepositoryInterface;

class BasketRepository implements BasketRepositoryInterface
{


    public function findForUser(int $userId, int $productId): ?Basket
    {
        return Basket::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    }

    public function findForSession(string $sessionId, int $productId): ?Basket
    {
        return Basket::where('session_id', $sessionId)
            ->where('product_id', $productId)
            ->first();
    }

    public function getUserItems(int $userId): Collection
    {
        return Basket::with('product')
            ->where('user_id', $userId)
            ->get();
    }

    public function getSessionItems(string $sessionId): Collection
    {
        return Basket::with('product')
            ->where('session_id', $sessionId)
            ->get();
    }

    public function create(array $data): Basket
    {
        return Basket::create($data);
    }

    public function increaseQuantity(Basket $basket, int $quantity = 1): void
    {
        $basket->increment('quantity', $quantity);
    }

    public function decreaseQuantity(Basket $basket, int $quantity = 1): void
    {
        if ($basket->quantity <= $quantity) {
            $basket->delete();
            return;
        }

        $basket->decrement('quantity', $quantity);
    }

    public function delete(Basket $basket): void
    {
        $basket->delete();
    }

    public function countForUser(int $userId): int
    {
        return Basket::where('user_id', $userId)->sum('quantity');
    }

    public function countForSession(string $sessionId): int
    {
        return Basket::where('session_id', $sessionId)->sum('quantity');
    }
}
