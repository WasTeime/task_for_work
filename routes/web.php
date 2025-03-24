<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('products.index');
        Route::get('/show/{productId}', [ProductsController::class, 'show'])->name('products.show');
    });

    Route::prefix('cart')->group(function() {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add/{productId}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/show/{orderId}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/create/{orderId}', [OrderController::class, 'createSuccess'])->name('orders.success');
        Route::post('/create', [OrderController::class, 'create'])->name('orders.create');
        Route::get('/edit/{orderId}', [OrderController::class, 'editScreen'])->name('orders.editScreen');
        Route::post('/edit/{orderId}', [OrderController::class, 'edit'])->name('orders.edit');
        Route::post('/delete/{orderId}', [OrderController::class, 'delete'])->name('orders.delete');
        Route::post('/{orderId}/mark-as-delivered', [OrderController::class, 'markAsDelivered'])
            ->name('orders.markAsDelivered');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
    });

    Route::prefix('products')->group(function () {
        Route::get('/create', [ProductsController::class, 'createScreen'])->name('products.create');
        Route::post('/create', [ProductsController::class, 'store'])->name('products.store');
        Route::get('/edit/{productId}', [ProductsController::class, 'editScreen'])->name('products.edit');
        Route::post('/edit/{productId}', [ProductsController::class, 'store'])->name('products.update');
        Route::post('/delete/{productId}', [ProductsController::class, 'delete'])->name('products.delete');
    });
});

require __DIR__.'/auth.php';
