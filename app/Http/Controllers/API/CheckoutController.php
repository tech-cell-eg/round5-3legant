<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'phone'      => 'required|string',
            'email'      => 'required|email',
            'address'    => 'required|string',
            'country'    => 'required|string',
            'city'       => 'required|string',
            'payment_method' => 'required|in:cash,credit_card,paypal',
            'items'      => 'required|array',
            'items.*.product_variation_id' => 'required|exists:product_variations,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;

            foreach ($request->items as $item) {
                $variation = ProductVariation::findOrFail($item['product_variation_id']);
                $subtotal += $item['quantity'] * $variation->price;
            }

            $discount = 0; 
            $total = $subtotal - $discount;

            $order = Order::create([
                'user_id' => $request->input('user_id'),
                'first_name'=> $request->first_name,
                'last_name' => $request->last_name,
                'phone'     => $request->phone,
                'email'     => $request->email,
                'address'   => $request->address,
                'country'   => $request->country,
                'city'      => $request->city,
                'state'     => $request->state,
                'zip_code'  => $request->zip_code,
                'payment_method' => $request->payment_method,
                'subtotal'  => $subtotal,
                'discount'  => $discount,
                'total'     => $total,
            ]);

            foreach ($request->items as $item) {
                $variation = ProductVariation::findOrFail($item['product_variation_id']);

                OrderItem::create([
                    'order_id'             => $order->id,
                    'product_variation_id' => $variation->id,
                    'quantity'             => $item['quantity'],
                    'price'                => $variation->price,
                ]);

                
                
            }

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Order placed successfully',
                'data'    => $order->load('items.variation.product')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Order failed: '.$e->getMessage()
            ], 500);
        }
    }
}

