<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductQuantityCartRule implements ValidationRule
{
    protected $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Product::find($this->productId);
        if (!$product || $product->stock < $value) {
            $fail('The quantity exceeds the available stock for this product.');
        }

    }
}
