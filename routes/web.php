<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminPanelUserController;
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

Route::get('/', [ProductsController::class, 'index'])->middleware(['auth', 'verified'])->name('products');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('products.index');
        Route::get('/show/{productId}', [ProductsController::class, 'show'])->name('products.show');
    });

    Route::prefix('cart')->group(function() {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add/{productId}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
    });

    //Вынести бизнес логику в сервисы (вынести в сервисы CRUD) а в контроллерах просто обращаться к этим сервисам
    Route::middleware('check.role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::prefix('users')->group(function () {
            Route::get('/', [AdminPanelUserController::class, 'index'])->name('admin.users');
        });
        Route::prefix('products')->group(function () {
            Route::get('/create', [ProductsController::class, 'createScreen'])->name('products.create');
            Route::post('/create', [ProductsController::class, 'store'])->name('products.store');
            Route::get('/edit/{productId}', [ProductsController::class, 'editScreen'])->name('products.edit');
            Route::post('/edit/{productId}', [ProductsController::class, 'store'])->name('products.update');
            Route::post('/delete/{productId}', [ProductsController::class, 'delete'])->name('products.delete');
        });
    });
});

require __DIR__.'/auth.php';
