<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = CartItem::class;
    public function definition(): array {
        return [
            'cart_id' => Cart::factory(),
            'product_variation_id' => ProductVariation::factory(),
            'quantity' => 5,
            'price' => 5.00,
            'sub_total' => 75.00,
        ];
    }
}
