<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\CartRepo;

class CartService
{
    protected $cartRepo;
    protected $inventoryService;

    public function __construct(
        CartRepo $cartRepo,
        InventoryService $inventoryService
    ) {
        $this->cartRepo = $cartRepo;
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
        $products = Product::whereIn('id', array_keys($data))->get()->keyBy('id');
        $result = collect($data)->map(function ($quantity, $productId) use ($products) {
            $product = $products->get($productId);
            return $product ? [
                'product' => $product,
                'quantity' => $quantity,
            ] : null;
        })->filter()->values()->all();
        return $result;
    }
}
