<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\APIResponseTrait;
use App\Models\Product;
class ProductController extends Controller
{
    use APIResponseTrait;
    // category_id    priceRange from to   
    //دي الحجات اللي الفرونت ممكن يبعتها
    public function getProducts(Request $request){
        $query=Product::join("categories","products.category_id","=","categories.id")->select("categories.*","products.*");
        
        if($request->filled("category")){
            $query->where("categories.id",$request->category_id);
        }

        if($request->filled("from")&&$request->filled("to")){
            $query->where("products.base_price",">=",$request->from);
            $query->where("products.base_price","<=",$request->to);
        }
        $products = $query->cursorPaginate(30);

        return $this->successResponse($products,"products fetched successfully",200);
    }


    //sorted=price or latest  order=[desc or asc] 
    //دي الحجات اللي الفرونت ممكن يبعتها
   public function sortedProducts(Request $request)
    {
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

            $query->orderBy("products.".$sortedBy, $direction);
        }
        else{
            return $this->errorResponse("bad parameters were passed");
        }

        $products = $query->cursorPaginate(30);

        return $this->successResponse($products, "Products fetched successfully", 200);
    }



}
