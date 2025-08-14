<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())->first();

        if (!$wishlist) {
            return response()->json([
                'status' => false,
                'message' => 'No wishlist found for this user'
            ], 404);
        }
        $products = $wishlist->products()->paginate(3);
        return response()->json([
            'status' => true,
            'data' => $products
        ]);

    }
    
}
