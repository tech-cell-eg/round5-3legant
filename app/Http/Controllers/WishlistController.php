<?php

namespace App\Http\Controllers;

use App\Models\Product;
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


    public function addProduct(Request $request , $productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $wishlist = Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
        ]);
        if ($wishlist->products()->where('product_id', $productId)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Product already in wishlist'
            ]);
        }

            $wishlist->products()->attach($productId);

        return response()->json([
            'status' => true,
            'message' => 'Product added to wishlist successfully',
        ]);

    }


    public function removeProduct(Request $request, $productId)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())->first();
        if (!$wishlist) {
            return response()->json([
                'status' => false,
                'message' => 'Wishlist not found'
            ], 404);
        }

        if (!$wishlist->products()->where('product_id', $productId)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found in wishlist'
            ]);
        }
          $wishlist->products()->detach($productId);
           return response()->json([
            'status' => true,
            'message' => 'Product removed from wishlist successfully'
        ], 200);
    }
    
}
