<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\RepositoryInterface;

class ProductRepo implements RepositoryInterface {

    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function all(){
        return $this->product->get();
    }

    public function create($data){
        return $this->product->create($data);
    }

    public function find($id){
        return $this->product->findOrFail($id);
    }

    public function update($id, $data){
        $this->find($id)->update($data);
    }

    public function delete($id){
        return $this->find($id)->delete();
    }

}
