<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PharmacyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'full_name'=>$this->full_name,
            'pharmacy_name'=>$this->pharmacy_name,
            'pharmacy_address'=>$this->pharmacy_address, 
            'rule'=>$this->rule,
            'phone'=>$this->phone,
        ];
    }
}
