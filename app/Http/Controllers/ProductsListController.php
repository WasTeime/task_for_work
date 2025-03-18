<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ProductsListController extends Controller
{
    public function index()
    {
        return view('products.index', compact('products'));
    }
}
