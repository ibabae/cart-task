<?php

namespace App\Services;

use App\Jobs\SendProductCreatedMail;
use App\Repositories\ProductRepo;

class ProductService{

    public function __construct(
        protected ProductRepo $productRepo
    ){}
    public function getProducts(){
        return $this->productRepo->all();
    }

    public function createProduct($data){
        $product = $this->productRepo->create($data);
        SendProductCreatedMail::dispatch($product);
        return $product;
    }

    public function getProductById($id){
        return $this->productRepo->find($id);
    }

    public function updateProduct($id, $data){
        $this->productRepo->update($id, $data);
        return $this->productRepo->find($id);
    }

    public function deleteProduct($id){
        return $this->productRepo->delete($id);
    }
}
