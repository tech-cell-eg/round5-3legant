<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    public function index() {
        $counts = [
            'products' => Product::count(),
            'product_variations' => ProductVariation::count(),
            'customers' => User::role('customer')->count(),
        ];
        // dd($counts);
        return view('admin.dashboard.home', compact('counts'));
    }
}
