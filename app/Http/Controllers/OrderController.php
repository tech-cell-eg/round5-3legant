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
}
