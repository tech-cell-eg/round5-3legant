<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    public function index() {
        $counts = [
            'products' => Product::count(),
            'orders' => Order::count(),
            'customers' => User::role('customer')->count(),
        ];
        return view('admin.dashboard.home', compact('counts'));
    }
}
