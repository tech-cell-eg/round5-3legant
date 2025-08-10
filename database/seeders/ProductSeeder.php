<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Product::create([
            'name'        => "table",
            'description' => "black small table",
            'base_price'  => 30,
            'category_id' => 1
            ]);
            Product::create([
            'name'        => "door",
            'description' => "black small chair",
            'base_price'  => 40,
            'category_id' => 2
            ]);
            Product::create([
            'name'        => "door",
            'description' => "red door",
            'base_price'  => 200,
            'category_id' => 2
            ]);
            Product::create([
            'name'        => "table",
            'description' => "whte small table",
            'base_price'  => 30,
            'category_id' => 1
            ]);
            Product::create([
            'name'        => "table",
            'description' => "red big table",
            'base_price'  => 30,
            'category_id' => 1
            ]);

    }
}
