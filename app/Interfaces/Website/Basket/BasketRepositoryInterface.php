<?php

namespace App\Interfaces\Website\Basket;

use App\Models\Basket;
use Illuminate\Support\Collection;

interface BasketRepositoryInterface
{
       public function findForUser(int $userId, int $productId): ?Basket;

    public function findForSession(string $sessionId, int $productId): ?Basket;

    public function getUserItems(int $userId): Collection;

    public function getSessionItems(string $sessionId): Collection;

    public function create(array $data): Basket;

    public function increaseQuantity(Basket $basket, int $quantity = 1): void;

    public function decreaseQuantity(Basket $basket, int $quantity = 1): void;

    public function delete(Basket $basket): void;

    public function countForUser(int $userId): int;

    public function countForSession(string $sessionId): int;
}
