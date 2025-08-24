<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariation>
 */
class ProductVariationFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ProductVariation::class;
    public function definition(): array {
        $sizes = ['S', 'M', 'L', 'XL'];
        $colors = ['Red', 'Blue', 'Black', 'White'];
        return [
            'product_id' => Product::factory(),
            'size'       => $this->faker->randomElement($sizes),
            'color'      => $this->faker->randomElement($colors),
            'quantity'   => $this->faker->numberBetween(10, 50),
            'price'      => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
