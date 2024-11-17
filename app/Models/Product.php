<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table="products";

    protected $fillable=[
        'scientific_name',
        'commercial_name',
        'manufacturer',
        'img_path',
        'price',
        'quantity',
       'expiration_date',
       'category_id',
       'user_id'
    ];

    public function category()
    {
        //return $this->belongTo(Category::class, 'category_id');
        return $this->belongsTo(Category::class,'category_id');
    }

    public function  user()
    {
       // return $this->belongsTo(User::class, 'user_id');
        return $this->belongsTo(User::class,'user_id');
    }
  
public function orders()
{
  return $this->belongsToMany(Order::class,'order_product','product_id','order_id','id','id')->withPivot('orderQuantity');
}
}
