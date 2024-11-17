<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\ValidationException;

class CartDBRepo implements RepositoryInterface
{
    protected $user;

    public function __construct()
    {
        $this->user = User::findOrFail(auth()->id());
    }

    public function all(){
        return $this->user->cart;
    }

    public function find(int $productId)
    {
        return $this->user->cart->with('items',function($query) use ($productId){
            $query->whereHas('product_id', $productId);
        });
    }

    public function create(array $data)
    {
        $cart = $this->user->cart ?: $this->user->cart()->create(['user_id' => $this->user->id]);
        $cart->items()->firstOrCreate([
            'product_id' => $data['product_id'],
        ],[
            'quantity' => $data['quantity']
        ]);
    }

    public function update(int $id, array $data)
    {
    }

    public function delete(int $productId)
    {
        $this->user->cart->items()->where('id', $productId)->delete();
        // Redis::hdel($this->cartKey, $productId);
    }
}
