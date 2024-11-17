<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Product;

class AddOrder implements Rule
{

    private $attribute;
  
    public function __construct($attribute)
    {
        $this->attribute = $attribute;
    }

    public function passes($attribute, $value)
    {

        $products = $this->$attribute;
        foreach ($products as $productData) {
            $productId = $productData['product_id'];
            $orderQuantity = $productData['order_quantity'];

            $product = Product::find($productId);
            if (!$product) {
                throw new \Exception("The product with ID {$productId} does not exist.");
            }

            if ($orderQuantity > $product->quantity) {
                throw new \Exception("The order quantity for product ID {$productId} exceeds the available quantity.");
            }
        return $value ;
    }

}
    public function message()
    {
       return 'The  '. $this->attribute. '   quantity requested must be less than or equal to the available quantity';
    }

}