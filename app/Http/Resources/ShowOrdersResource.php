<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class ShowOrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::find($this->store_id);
        return [
            'id' => $this->id,
            'store_name' => $user ? $user->pharmacy_name : null,
            'order_status' => $this->order_status,
            'payment_status' => $this->payment_status,
            'products' => $this->products,
        ];    
    }
}
