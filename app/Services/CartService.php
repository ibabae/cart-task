<?php

namespace App\Services;

use App\Repositories\CartRepo;
use App\Repositories\ProductRepo;

class CartService
{
    protected $cartRepo;
    protected $productRepo;
    protected $inventoryService;

    public function __construct(
        CartRepo $cartRepo,
        ProductRepo $productRepo,
        InventoryService $inventoryService
    ) {
        $this->cartRepo = $cartRepo;
        $this->productRepo = $productRepo;
        $this->inventoryService = $inventoryService;
    }

    public function getCart()
    {
        return $this->cartData($this->cartRepo->all());
    }

    public function addToCart($data)
    {
        $this->cartRepo->create($data);
        $this->inventoryService->reduceStock($data);
        return $this->getCart();
    }

    public function removeFromCart($productId)
    {
        $cartItem = $this->cartRepo->find($productId);
        if ($cartItem) {
            $this->inventoryService->increaseStock($productId, $cartItem);
            $this->cartRepo->delete($productId);
        }
        return $this->getCart();
    }

    private function cartData($data)
    {
        return collect($data)->map(function ($quantity, $productId) {
            $product = $this->productRepo->find($productId);
            return $product ? [
                'product' => $product,
                'quantity' => $quantity
            ] : null;
        })->filter()->values()->all();
    }
}
