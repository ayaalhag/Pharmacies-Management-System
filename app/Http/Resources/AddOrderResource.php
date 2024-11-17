<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'pharmacist_id' => $this->pharmacist_id,
            'store_id'=>$this->store_id,
            'order_status'=>$this->order_status,
            'payment_status'=>$this->payment_status,
            'products'=>$this->products,
            //'products.price'=>
         ];       
    }
}
