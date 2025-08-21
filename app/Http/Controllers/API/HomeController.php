<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use App\Models\Product;
use App\Models\Category;
use App\Models\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller {
    public function categories() {
        $categories = Category::select('id', 'name')->get();

        return response()->json([
            'status' => true,
            'message' => 'Categories retrieved successfully',
            'data' => $categories
        ]);
    }

    public function newArrivals() {
        $products = Product::select('id', 'name', 'base_price', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'New products retrieved successfully',
            'data' => $products
        ]);
    }


    public function moreProducts() {
        $products = Product::select('id', 'name', 'base_price', 'views')
            ->orderBy('views', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'More products retrieved successfully',
            'data' => $products
        ]);
    }


    public function shopCollections() {
        $collections = Collection::with(['products' => function ($query) {
            $query->select('products.id', 'name', 'base_price');
        }])
            ->where('is_featured', true)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Shop collections retrieved successfully',
            'data' => $collections
        ]);
    }


    public function bestSellers() {
        $products = Product::select(
            'products.id',
            'products.name',
            'products.base_price',
            DB::raw('SUM(order_items.quantity) as total_sold')
        )
            ->join('product_variations', 'products.id', '=', 'product_variations.product_id')
            ->join('order_items', 'product_variations.id', '=', 'order_items.product_variation_id')
            ->groupBy('products.id', 'products.name', 'products.base_price')
            ->orderByDesc('total_sold')
            ->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Best sellers retrieved successfully',
            'data' => $products
        ]);
    }
    public function blogList() {
        $articles = Article::select('id', 'title', 'image', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->through(function ($article) {
                $article->image = $article->image
                    ? asset('storage/articles/' . $article->image)
                    : null;
                $article->date = $article->created_at->format('Y-m-d');
                unset($article->created_at);
                return $article;
            });

        return response()->json([
            'status' => true,
            'message' => 'Articles retrieved successfully',
            'data' => $articles
        ]);
    }

    public function blogDetails($id) {
        $article = Article::select('id', 'title', 'image', 'content', 'created_at')
            ->find($id);

        if (!$article) {
            return response()->json([
                'status' => false,
                'message' => 'Article not found'
            ], 404);
        }

        $article->image = $article->image
            ? asset('storage/articles/' . $article->image)
            : null;

        $article->date = $article->created_at->format('Y-m-d');
        unset($article->created_at);

        return response()->json([
            'status' => true,
            'message' => 'Article details retrieved successfully',
            'data' => $article
        ]);
    }
}
