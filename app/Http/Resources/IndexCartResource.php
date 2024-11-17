<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexCartResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->transform(function($product){
            return [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
            ];
        })->toArray();
    }
}
