<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class AdminController extends Controller
{
    public function index() {
        $usersCount = User::count();
        $productsCount = Product::count();
        return view('admin.dashboard', compact('usersCount', 'productsCount'));
    }
}
