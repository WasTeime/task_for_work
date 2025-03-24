<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() {
        $usersCount = User::count();
        $productsCount = Product::count();
        $ordersCount = Order::count();
        return view('dashboard', compact('usersCount', 'productsCount', 'ordersCount'));
    }
}
