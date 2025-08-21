<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\ProductVariation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;

class CartTest extends TestCase {
    use RefreshDatabase;

    public function test_get_the_user_cart(): void {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->getJson('/api/cart');
        $response->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'User Cart.',
            'data' => [
                'user_id' => $user->id
            ]
        ]);
    }

    public function test_add_to_cart(): void {
        $user = User::factory()->create();
        $variation = ProductVariation::factory()->create();
        $data = [
            'product_variation_id' => $variation->id,
            'quantity' => 2,
        ];
        $response = $this->actingAs($user, 'sanctum')->postJson('/api/add-to-cart', $data);
        $response->assertStatus(201)->assertJson([
            'success' => true,
            'message' => 'Item added to cart',
        ]);
    }

    public function test_cannot_add_to_cart_if_stock_not_enough(): void {
        $user = User::factory()->create();
        $variation = ProductVariation::factory()->create(['quantity' => 1]);
        $data = [
            'product_variation_id' => $variation->id,
            'quantity' => 5,
        ];
        $response = $this->actingAs($user, 'sanctum')->postJson('/api/add-to-cart', $data);
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Somting went wrong',
                'errors' => 'Stock not enough',
            ]);
    }

    public function test_update_cart() {
        $cartItem = CartItem::factory()->create();
        $user = $cartItem->cart->user;
        $data = [
            'quantity' => 2,
        ];
        $response = $this->actingAs($user, 'sanctum')->putJson("/api/update-cart-item/{$cartItem->id}", $data);
        $response->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Item Updated',
        ]);
    }

    public function test_cannot_update_cart_if_stock_not_enough(): void {
        $cartItem = CartItem::factory()->create();
        $user = $cartItem->cart->user;
        $data = [
            'quantity' => 60,
        ];
        $response = $this->actingAs($user, 'sanctum')->putJson("/api/update-cart-item/{$cartItem->id}", $data);
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Cart item Can\'t be updated',
                'errors' => 'Stock not enough',
            ]);
    }

    public function test_cannot_update_cart_if_not_belong(): void {
        $cartItem = CartItem::factory()->create();
        $otherUser = User::factory()->create();
        $data = [
            'quantity' => 60,
        ];
        $response = $this->actingAs($otherUser, 'sanctum')->putJson("/api/update-cart-item/{$cartItem->id}", $data);
        $response->assertStatus(404)->assertJson([
            "success" => false,
            "message" => "Cart item Can't be updated",
            "errors" => "Can't find cart item"
        ]);
    }

    public function test_remove_item_from_cart() {
        $cartItem = CartItem::factory()->create();
        $user = $cartItem->cart->user;
        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/remove-cart-item/{$cartItem->id}");
        $response->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Item removed from cart',
        ]);
    }
    public function test_apply_shipping() {
        $cart = Cart::factory()->create();
        $data = ['shipping_type' => Arr::random(['free', 'express', 'pickup'])];
        $response = $this->actingAs($cart->user, 'sanctum')->postJson('api/cart/apply-shipping', $data);
        $response->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Shipping applied',
            'data' => [],
        ]);
    }
    public function test_apply_discount() {
        $cart = Cart::factory()->create();
        $coupon = Coupon::factory()->create();
        $data = ['code' => $coupon->code];
        $response = $this->actingAs($cart->user, 'sanctum')->postJson('api/cart/apply-coupon', $data);
        $response->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Coupon Applied successful',
            'data' => [],
        ]);
    }
    public function test_apply_invalid_discount(): void {
        $cart = Cart::factory()->create();
        $data = ['code' => 'INVALIDCODE'];
        $response = $this->actingAs($cart->user, 'sanctum')->postJson('api/cart/apply-coupon', $data);
        $response->assertStatus(500)
            ->assertJson([
                "success" => false,
                "message" => "Can't apply coupon",
                "errors" => "The selected code is invalid."
            ]);
    }
}
