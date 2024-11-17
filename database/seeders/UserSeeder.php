<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public static $password;
    public function run(): void
    {
        User::factory()->count(1)->create();

    }
}
