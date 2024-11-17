<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    public function items(){
        return $this->hasMany(CartItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getTotalPrice(){
        return $this->cartItems->sum(function($item){
            return $item->product->price * $item->quantity;
        });
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'cart_items', 'cart_id','product_id')->withPivot('quantity');
    }
}
