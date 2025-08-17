<?php

namespace App\Http\Controllers\Admin;

use Storage;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;

class VaritaionsController extends Controller {
    public function deleteVariation($id) {
        $variation = ProductVariation::findOrFail($id);
        foreach ($variation->images as $img) {
            \Storage::disk('public')->delete($img->image);
            $img->delete();
        }

        $variation->delete();

        return back()->with('success', 'Variation deleted successfully!');
    }
    public function deleteVariationImage($id) {
        $image = ProductImage::findOrFail($id);
        \Storage::disk('public')->delete($image->image);
        $image->delete();
        return back()->with('success', 'Image deleted successfully!');
    }
}
