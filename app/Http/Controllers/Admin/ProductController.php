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
        $products = Product::with(['productVariations', 'category'])->get();
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
                    $variation = ProductVariation::create([
                        'product_id' => $product->id,
                        'color' => $var['color'] ?? null,
                        'size' => $var['size'] ?? null,
                        'measurements' => $var['measurements'] ?? null,
                        'quantity' => $var['quantity'] ?? 0,
                        'price' => $var['price'] ?? $product->base_price,
                    ]);
                    if (isset($var['product_images']) && is_array($var['product_images'])) {
                        $imageNumber = 0;
                        foreach (($var['product_images']) as $image) {
                            $imageNumber++;
                            $this->saveVariationImage($variation, $image, $imageNumber);
                        }
                    }
                }
            }
            if ($request->action == 'save') {
                return redirect()->route('products.index')->with('success', 'Product Created Successfully');
            }
            return back()->with('success', 'Product Created Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Somting went Wrong' . $e->getMessage());
        }
    }


    public function edit(string $id) {
        $product = Product::findOrFail($id);
        $categories = Category::pluck('name', 'id')->toArray();
        $variations = ProductVariation::where('product_id', '=', $id)->with('images')->get();
        return view('admin.product.edit', compact('product', 'variations', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'base_price' => $request->base_price,
        ]);
        if (!empty($request->variations)) {
            foreach ($request->variations as $key => $var) {
                if (str_starts_with($key, 'new_')) {
                    $variation = ProductVariation::create([
                        'product_id' => $product->id,
                        'color' => $var['color'] ?? null,
                        'size' => $var['size'] ?? null,
                        'measurements' => $var['measurements'] ?? null,
                        'quantity' => $var['quantity'] ?? 0,
                        'price' => $var['price'] ?? $product->base_price,
                    ]);
                    if (!empty($var['product_images'])) {
                        $imageNumber = 0;
                        foreach ($var['product_images'] as $image) {
                            $imageNumber++;
                            $this->saveVariationImage($variation, $image, $imageNumber);
                        }
                    }
                } else {
                    $variation = ProductVariation::findOrFail($key);
                    $variation->update([
                        'color' => $var['color'] ?? null,
                        'size' => $var['size'] ?? null,
                        'measurements' => $var['measurements'] ?? null,
                        'quantity' => $var['quantity'] ?? 0,
                        'price' => $var['price'] ?? $product->base_price,
                    ]);
                    if (!empty($request->file("variation_images.$key"))) {
                        $imageNumber = 0;
                        foreach ($request->file("variation_images.$key") as $image) {
                            $imageNumber++;
                            $this->saveVariationImage($variation, $image, $imageNumber);
                        }
                    }
                }
            }
        }
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    // Handle images
    private function saveVariationImage(ProductVariation $variation, $image, $imageNumber) {
        $date = now()->format('Ymd');
        $extension = $image->getClientOriginalExtension();
        $imageName = "PR{$variation->product_id}-VAR{$variation->id}-{$date}-{$imageNumber}." . $extension;
        $path = $image->storeAs('product_images', $imageName, 'public');
        ProductImage::create([
            'product_variation_id' => $variation->id,
            'image' => $path,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $product = Product::findOrFail($id);
        $product->delete();
        return back()
            ->with('success', 'Product deleted successfully.');
    }
}
