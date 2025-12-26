<?php

namespace App\Services\Website\Basket;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Product;
use App\Interfaces\Website\Basket\BasketRepositoryInterface;

class BasketService
{
    public function __construct(
        private BasketRepositoryInterface $basketRepository
    ) {}

  public function add(int $productId, int $quantity = 1): array
    {
        $product = Product::findOrFail($productId);

        // ================= USER =================
        if (Auth::check()) {

            $basket = $this->basketRepository
                ->findForUser(Auth::id(), $productId);

            $currentQty   = $basket?->quantity ?? 0;
            $requestedQty = $currentQty + $quantity;

            if ($requestedQty > $product->stock) {
                return [
                    'status'  => 'error',
                    'message' => 'Stokda kifayət qədər məhsul yoxdur.'
                ];
            }

            if ($basket) {
                $this->basketRepository->increaseQuantity($basket, $quantity);
            } else {
                $this->basketRepository->create([
                    'user_id'    => Auth::id(),
                    'product_id' => $productId,
                    'quantity'   => $quantity,
                ]);
            }

            return [
                'status'        => 'success',
                'basket_count'  => $this->basketRepository->countForUser(Auth::id())
            ];
        }

        // ================= GUEST =================
        $sessionId = session()->getId();

        $basket = $this->basketRepository
            ->findForSession($sessionId, $productId);

        $currentQty   = $basket?->quantity ?? 0;
        $requestedQty = $currentQty + $quantity;

        if ($requestedQty > $product->stock) {
            return [
                'status'  => 'error',
                'message' => "Bu məhsuldan maksimum {$product->stock} ədəd ala bilərsiniz"
            ];
        }

        if ($basket) {
            $this->basketRepository->increaseQuantity($basket, $quantity);
        } else {
            $this->basketRepository->create([
                'session_id' => $sessionId,
                'product_id' => $productId,
                'quantity'   => $quantity,
            ]);
        }

        return [
            'status'        => 'success',
            'basket_count'  => $this->basketRepository->countForSession($sessionId)
        ];
    }
}
