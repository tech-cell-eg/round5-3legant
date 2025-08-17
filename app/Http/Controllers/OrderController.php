<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $orders = Order::with(['items.productVariation'])
        ->where('user_id', $user->id)
        ->latest()
        ->paginate(10);


        return response()->json([
            'status'=>true,
            'data'=> $orders
        ]);
    }
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







   
