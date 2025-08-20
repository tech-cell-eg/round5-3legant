<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;
    public function definition(): array {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'base_price'  => $this->faker->randomFloat(2, 50, 500),
            'category_id' => Category::factory(),
        ];
    }
}
