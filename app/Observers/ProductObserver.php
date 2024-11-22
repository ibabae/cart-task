<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Redis;


class ProductObserver
{
    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product)
    {
        $cartKey = 'cart:user:';
        $cartKeys = Redis::keys($cartKey . '*');

        foreach ($cartKeys as $key) {
            Redis::hdel($key, $product->id);
        }
    }
}
