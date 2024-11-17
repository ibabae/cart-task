<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\ValidationException;

class CartRepo implements RepositoryInterface
{
    protected $cartKeyPrefix = 'cart:';
    protected $userId;
    protected $cartKey;

    public function __construct()
    {
        $this->userId = auth()->id();
        $this->cartKey = $this->getCartKey();
    }

    private function getCartKey()
    {
        return $this->cartKeyPrefix . $this->userId;
    }

    public function all(){
        return Redis::hgetall($this->cartKey);
    }

    public function find(int $productId)
    {
        return Redis::hget($this->cartKey, $productId);
    }

    public function create(array $data)
    {
        if (Redis::hexists($this->cartKey, $data['product_id'])) {
            throw ValidationException::withMessages(['product_exists'=>'Product is currently exists in your cart.']);
        }
        Redis::hset($this->cartKey, $data['product_id'], $data['quantity']);
        Redis::expire($this->cartKey, 86400); // Expiration of Cart after 24 hours (86400 secounds)
    }

    public function update(int $id, array $data)
    {
    }

    public function delete(int $productId)
    {
        Redis::hdel($this->cartKey, $productId);
    }
}
