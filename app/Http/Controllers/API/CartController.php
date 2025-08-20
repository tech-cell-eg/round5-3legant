<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Traits\APIResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\ProductVariation;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller {
    use APIResponseTrait;
    public function index() {
        $cart = $this->getUserCart(auth()->user()->id);
        return $this->successResponse($cart, 'User Cart.', 200);
    }
    public function getUserCart($id) {
        return Cart::firstOrCreate(
            ['user_id' => $id],
            [
                'sub_total' => 0,
                'total_price' => 0,
            ],
        );
    }
    public function addToCart(Request $request) {
        try {
            $request->validate([
                'product_variation_id' => 'required|integer|exists:product_variations,id',
                'quantity' => 'required|integer|min:1',
            ]);
            $cart = $this->getUserCart(auth()->id());
            $productVariation = ProductVariation::findOrFail($request->product_variation_id);
            if (!$productVariation->checkTheStock($request->quantity)) {
                throw new \Exception('Stock not enough', 422);
            }
            $cartItem =  CartItem::where('cart_id', $cart->id)->where('product_variation_id', $productVariation->id)->first();
            if ($cartItem) {
                $cartItem->quantity += $request->quantity;
                $cartItem->sub_total = $cartItem->quantity * $productVariation->price;
                $cartItem->price = $productVariation->price;
                $cartItem->save();
            } else {
                $cartItem = CartItem::create([
                    'cart_id' => $cart->id,
                    'product_variation_id' => $productVariation->id,
                    'quantity' => $request->quantity,
                    'price' => $productVariation->price,
                    'sub_total' => $request->quantity * $productVariation->price,
                ]);
            }
            $cart = $this->calculateCart($cart);
            return $this->successResponse([], 'Item added to cart', 201);
        } catch (\Exception $e) {
            Log::error('Error : ' . $e->getMessage());
            $code = ($e->getCode() < 100 || $e->getCode() > 599) ? 500 : $e->getCode();
            return $this->errorResponse($e->getMessage(), 'Somting went wrong', $code);
        }
    }
    public function calculateCart(Cart $cart) {
        $sub_total = $cart->items()->sum(DB::raw('sub_total'));
        $discount = 0;
        if ($cart->coupon_id) {
            $coupon = Coupon::where('id', $cart->coupon_id)
                ->where('is_active', true)
                ->where('valid_until', '>=', now())
                ->firstOrFail();
            $discount = $this->applyTheCouponIfExists($coupon, $cart, $sub_total);
        }
        $shipping = $cart->shipping_cost ?? 0;
        $cart->sub_total = $sub_total;
        $cart->discount = $discount;
        $cart->total_price = max(0, $sub_total - $discount + $shipping);
        $cart->save();
        return $cart;
    }
    public function applyTheCouponIfExists(Coupon $coupon, Cart $cart, float $sub_total) {
        $discount = 0;
        if ($coupon->type === 'fixed') {
            $discount = min($coupon->value, $sub_total);
        } else {
            $discount = ($sub_total * $coupon->value) / 100;
        }
        $cart->coupon_id = $coupon->id;
        $cart->discount = $discount;
        return $discount;
    }
    public function updateItem(Request $request, $cartItemId) {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);

            $cartItem = CartItem::where('id', $cartItemId)
                ->whereHas('cart', fn($q) => $q->where('user_id', auth()->id()))
                ->first();
            if (!$cartItem) (throw new \Exception("Can't find cart item", 404));
            $productVariation = $cartItem->productVariation;
            if (!$productVariation->checkTheStock($request->quantity)) {
                throw new \Exception('Stock not enough', 422);
            }
            $cart = $cartItem->cart;
            $cartItem->quantity = $request->quantity;
            $cartItem->sub_total = $request->quantity * $cartItem->price;
            $cartItem->save();
            $cart = $this->calculateCart($cart);
            return $this->successResponse([], 'Item Updated', 200);
        } catch (\Exception $e) {
            $code = ($e->getCode() < 100 || $e->getCode() > 599) ? 500 : $e->getCode();
            return $this->errorResponse($e->getMessage(), 'Cart item Can\'t be updated', $code);
        }
    }
    public function removeItem(Request $request, $cartItemId) {
        try {
            $cartItem = CartItem::where('id', $cartItemId)
                ->whereHas('cart', fn($q) => $q->where('user_id', auth()->id()))
                ->first();
            if (!$cartItem) (throw new \Exception("Can't find cart item", 404));
            $cart = $cartItem->cart;
            $cartItem->delete();
            $cart = $this->calculateCart($cart);
            return $this->successResponse([], 'Item removed from cart', 200);
        } catch (\Exception $e) {
            $code = ($e->getCode() < 100 || $e->getCode() > 599) ? 500 : $e->getCode();
            return $this->errorResponse($e->getMessage(), 'Cart item Can\'t be removed', $code);
        }
    }
    public function applyCoupon(Request $request) {
        try {
            $request->validate([
                'code' => 'required|string|exists:coupons,code'
            ]);
            $cart = $this->getUserCart(auth()->id());
            $coupon = Coupon::where('code', $request->code)->where('is_active', true)
                ->where('valid_until', '>=', now())
                ->firstOrFail();
            if ($cart->coupon_id === $coupon->id) {
                throw new \Exception('You already applied this code to your cart');
            }
            $sub_total = $cart->sub_total;
            $discount = 0;
            if ($coupon->type === 'fixed') {
                $discount = min($coupon->value, $sub_total);
            } else {
                $discount = ($sub_total * $coupon->value) / 100;
            }
            $cart->discount = $discount;
            $cart->coupon_id = $coupon->id;
            $cart = $this->calculateCart($cart);
            return $this->successResponse($cart, 'Coupon Applied successful', 200);
        } catch (\Exception $e) {
            $code = ($e->getCode() < 100 || $e->getCode() > 599) ? 500 : $e->getCode();
            return $this->errorResponse($e->getMessage(), 'Can\'t apply coupon', $code);
        }
    }
    public function applyShipping(Request $request) {
        try {
            $request->validate([
                'shipping_type' => 'required|in:free,express,pickup',
            ]);
            $cart = $this->getUserCart(auth()->id());
            $subtotal = $cart->sub_total;
            $shippingCost = 0;
            switch ($request->shipping_type) {
                case 'free':
                    $shippingCost = 0;
                    break;
                case 'express':
                    $shippingCost = 15;
                    break;
                case 'pickup':
                    $shippingCost = $subtotal * 0.21;
                    break;
            }
            $cart->shipping_type = $request->shipping_type;
            $cart->shipping_cost = $shippingCost;
            $cart = $this->calculateCart($cart);
            return $this->successResponse($cart, 'Shipping applied', 200);
        } catch (\Exception $e) {
            $code = ($e->getCode() < 100 || $e->getCode() > 599) ? 500 : $e->getCode();
            return $this->errorResponse($e->getMessage(), 'Can\'t apply ', $code);
        }
    }
}
