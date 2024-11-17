<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\IsPharmacist;
use App\Rules\IsStore;
use App\Rules\AddOrder;
use App\Models\Product;
use Illuminate\Validation\Rule;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class AddOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
 
     
    public function rules(): array
    { 
         //$data= $this->products;
    return [
            'pharmacist_id' => ['required','exists:users,id',new IsPharmacist('pharmacist_id')],
            'store_id' => ['required','exists:users,id',new IsStore('store_id')],
            'products' =>  ['required','array'],
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.order_quantity' => [
                'required',
                'numeric',
                'min:1',
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {/*
       /* throw new ValidationException($validator, response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
        products
        
        $products= $this->data;
        //$products = $data['products'];

        // التحقق من الكمية المتاحة لكل منتج
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
        }*/
    }
}