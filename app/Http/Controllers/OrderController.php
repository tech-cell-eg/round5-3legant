<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function orders(){
        $orders=Order::join("users","orders.user_id","=","users.id")
        ->join("addresses","users.id",'=',"addresses.user_id")
        ->select("users.*","orders.*","addresses.*")->get();
        // dd($orders);
        return view("orders",["orders"=>$orders]);
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:orders,id',
            'status' => 'required|string|in:cancelled,pending,delivered,shipped',
        ]);

        $order = Order::findOrFail($request->id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Status updated successfully']);
    }

}
