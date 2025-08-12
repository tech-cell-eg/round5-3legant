<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $products = Product::with(['variations', 'category'])->get();
        return view('admin.product.index', compact('products'));
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
    public function store(AddProductRequest $request) {
        try {
            $product = Product::create([
                'name' => $request->name,
                'description' =>  $request->description,
                'category_id' => $request->category_id,
                'base_price' => $request->base_price,
            ]);
            if (!empty($request->variations)) {
                foreach ($request->variations as $var) {
                    ProductVariation::create([
                        'product_id' => $product->id,
                        'color' => $var['color'] ?? null,
                        'size' => $var['size'] ?? null,
                        'measurements' => $var['measurements'] ?? null,
                        'quantity' => $var['quantity'] ?? 0,
                        'price' => $var['price'] ?? $product->base_price,
                    ]);
                }
            }
            // dd($request);
            if ($request->hasFile('product_images')) {
                $imageNumber = 1;
                $date = now()->format('Ymd');
                foreach ($request->file('product_images') as $image) {
                    $extension = $image->getClientOriginalExtension();
                    $imageName = "PRO-{$date}-{$imageNumber}.{$extension}";
                    $path = $image->storeAs('product_images', $imageName, 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $path,
                    ]);
                }
            }
            if ($request->action == 'save') {
                return redirect()->route('products.index')->with('success', 'Product Created Successfully');
            }
            return back()->with('success', 'Product Created Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Somting went Wrong' . $e->getMessage());
        }
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
