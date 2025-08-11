<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\APIResponseTrait;
use App\Models\Product;
class ProductController extends Controller
{
    use APIResponseTrait;
    // category_id    priceRange from to   sorted [desc or asc] 
    public function getProducts(Request $request){
        $query=Product::join("categories","products.category_id","=","categories.id")->select("categories.*","products.*");
        
        if($request->filled("category")){
            $query->where("categories.id",$request->category_id);
        }

        if($request->filled("from")&&$request->filled("to")){
            $query->where("products.base_price",">=",$request->from);
            $query->where("products.base_price","<=",$request->to);
        }

       if ($request->filled('sorted')) {
            $direction = strtolower($request->sorted) === 'desc' ? 'desc' : 'asc';
            $query->orderBy('products.base_price', $direction);
        }

        

        $products = $query->cursorPaginate(30);

        return $this->successResponse($products,"products fetched successfully",200);
    }
}
