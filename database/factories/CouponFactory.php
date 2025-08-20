<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Coupon::class;
    public function definition(): array {
        return [
            'code' => fake()->uuid(),
            'type' => fake()->randomElement(['fixed', 'percentage']),
            'value' => fake()->randomElement([10, 20, 30]),
            'valid_from' => now(),
            'valid_until' => now()->addDays(7)
        ];
    }
}
