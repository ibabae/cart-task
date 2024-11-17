<?php

namespace App\Services;

use App\Repositories\ProductRepo;

class InventoryService
{
    protected $productRepo;

    public function __construct(ProductRepo $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function reduceStock($data)
    {
        $product = $this->productRepo->find($data['product_id']);
        $product->stock -= $data['quantity'];
        $product->save();
    }

    public function increaseStock($productId, $quantity)
    {
        $product = $this->productRepo->find($productId);
        $product->stock += $quantity;
        $product->save();
    }
}

