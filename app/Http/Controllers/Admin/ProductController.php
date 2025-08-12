<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $categories = Category::all();
        $products = Product::with(['variations', 'category'])->get();
        return view('admin.product.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $categories = Category::pluck('name', 'id')->toArray();
        return view('admin.product.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        dump($request->name);
        dump($request->category_id);
        dump($request->description);
        dump($request->price);
        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'color' => 'sometimes|string|max:255',
            'size' => 'sometimes|max:255',
            'measurements' => 'sometimes|max:255',
            'price' => 'sometimes|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);
        Product::updated([
            'name' => ''
        ]);
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
