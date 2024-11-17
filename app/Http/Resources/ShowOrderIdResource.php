<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class ShowOrderIdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::find($this->pharmacist_id);
        $store = User::find($this->store_id);
        return [
            'id' => $this->id,
            'pharmacist_name' => $user ? $user->pharmacy_name : null,
            'store_name' => $store? $store->pharmacy_name : null,
            'order_status' => $this->order_status,
            'payment_status' => $this->payment_status,
            'products' => $this->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'scientific_name' => $product->scientific_name,
                    'commercial_name' => $product->commercial_name,
                    'manufacturer' => $product->manufacturer,
                    'img_path' => $product->img_path,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'expiration_date' => $product->expiration_date,
                    'category_id' => $product->category_id,
                    'category_name' => $product->category->name, // اضافة اسم الفئة هنا
                    'user_id' => $product->user_id,
                    //'created_at' => $product->created_at,
                    //'updated_at' => $product->updated_at,
                    'orderQuantity' => $product->pivot->orderQuantity,
                ];
            }),
            //'products' => $this->products,
        ];
           }
}
