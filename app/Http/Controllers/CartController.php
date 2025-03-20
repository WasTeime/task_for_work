<?php

namespace App\Http\Controllers;

use App\Data\ProductData;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() {
        return 'index';
    }

    public function add(int $productId) {
        return 'add';
    }
}
