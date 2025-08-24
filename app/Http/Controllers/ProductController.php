<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\APIResponseTrait;
use App\Models\Product;

class ProductController extends Controller {
    use APIResponseTrait;
    // category_id    priceRange from to
    //دي الحجات اللي الفرونت ممكن يبعتها
    public function getProductsWithPagination(Request $request) {
        $query = Product::join("categories", "products.category_id", "=", "categories.id")->select("categories.*", "products.*");

        if ($request->filled("category")) {
            $query->where("categories.id", $request->category_id);
        }

        if ($request->filled("from") && $request->filled("to")) {
            $query->where("products.base_price", ">=", $request->from);
            $query->where("products.base_price", "<=", $request->to);
        }
        $products = $query->cursorPaginate(30);

        return $this->successResponse($products, "products fetched successfully", 200);
    }

    //sorted=price or latest  order=[desc or asc]
    //دي الحجات اللي الفرونت ممكن يبعتها
    public function sortedProducts(Request $request) {
        $query = Product::join("categories", "products.category_id", "=", "categories.id")
            ->select("categories.*", "products.*");

        if ($request->filled("sorted") && $request->filled("order")) {
            $allowedSorts = ['base_price', 'created_at'];
            $allowedDirections = ['asc', 'desc'];

            $sortedBy = in_array(strtolower($request->sorted), $allowedSorts)
                ? strtolower($request->sorted)
                : 'base_price';

            $direction = in_array(strtolower($request->order), $allowedDirections)
                ? strtolower($request->order)
                : 'asc';

            $query->orderBy("products." . $sortedBy, $direction);
        } else {
            return $this->errorResponse("bad parameters were passed");
        }

        $products = $query->cursorPaginate(30);

        return $this->successResponse($products, "Products fetched successfully", 200);
    }

    // category_id    priceRange from to
    //دي الحجات اللي الفرونت ممكن يبعتها
    public function getProductsWithoutPagination(Request $request) {
        $query = Product::join("categories", "products.category_id", "=", "categories.id")->select("categories.*", "products.*");

        if ($request->filled("category")) {
            $query->where("categories.id", $request->category_id);
        }

        if ($request->filled("from") && $request->filled("to")) {
            $query->where("products.base_price", ">=", $request->from);
            $query->where("products.base_price", "<=", $request->to);
        }
        $products = $query->get();

        return $this->successResponse($products, "products fetched successfully", 200);
    }

    public function productSearch(Request $request) {
        $search = $request->search;

        $products = Product::where('base_price', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->get();

        return $this->successResponse($products, "Products fetched successfully");
    }


    public function productDetails($id) {
        $product = Product::query()
            ->join("product_images", "products.id", "=", "product_images.product_variation_id")
            ->join("product_variations", "products.id", "=", "product_variations.product_id")
            ->where("products.id", $id)
            ->select("products.*", "product_images.*", "product_variations.*")
            ->first();

        if (!$product) {
            return $this->errorResponse("The product is not found", 404);
        }

        return $this->successResponse($product, "Product fetched successfully", 200);
    }

    public function relatedProducts($category_id) {
        $products = Product::where("category_id", "=", $category_id)->cursorPaginate(30);
        if (!$products) {
            return $this->errorResponse("there are not any products", 404);
        }

        return $this->successResponse($products, "Products fetched successfully", 200);
    }
}
