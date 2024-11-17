<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // $category = Category::where('id', $this->category_id)->get;
        return [
            'id' =>$this->id,
            'category_id' =>$this->category_id,
            'scientific_name'=>$this->scientific_name,
            'commercial_name'=>$this->commercial_name,
            'manufacturer'=>$this->manufacturer, 
            'img_path'=>$this->img_path,
            'price'=>$this->price,
            'quantity'=>$this->quantity,
            'expiration_date'=>$this->expiration_date,
            //'category_name' => $category ? $category->category_name : null,
            'user_id'=>$this->user?->name ,
             ];

           
    }
}
