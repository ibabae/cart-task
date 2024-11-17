<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\ValidationException;

class CartRepo implements RepositoryInterface
{
    protected $user;

    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
        $this->user = User::findOrFail(auth()->id());
    }

    public function all(){
        return $this->cart->firstWhere('user_id', $this->user->id);
        // return Card::where
    }

    public function find(int $productId)
    {
        return $this->user->cart->items->firstWhere('product_id',$productId);
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
        $this->user->cart->items->firstWhere('product_id', $productId)->delete();
    }
}
