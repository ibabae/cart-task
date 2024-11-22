<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    protected $fillable = ['title','price','stock'];
}
