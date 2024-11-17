<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'scientific_name'=> "muscadol",
            //fake()->name(),
            'commercial_name'=> "MUSCADOL",
            //fake()->name(),
            'manufacturer'=> "Julphar",
            //fake()->name(),
            'img_path'=> "images/muscadol.jpg",
            //fake()->name(),
            'price'=> "3854",
            //fake()->randomFloat(),
            'quantity'=> "471",
            //fake()->randomNumber(),
            'expiration_date'=>"2024-02-24",
            // fake()->date('Y-m-d', '2024-12-12'),
            'category_id' => 1,
            'user_id' => 1,
        ];
    }
}
