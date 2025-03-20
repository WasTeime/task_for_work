<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\View\View;
use App\Data\CategoryData;
use Illuminate\Support\Facades\Log;
use App\Data\ProductData;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\ProductService;


//нужно сделать создание продукта и его редактирование, также удаление продукта
class ProductsController extends Controller
{
    public function index()
    {
        $products = ProductService::getAll();
        if (Auth::user()->isAdmin()) {
            return view('admin.products.index', compact('products'));
        }
        return view('products.index', compact('products'));
    }

    public function show(int $productId) {
        try {
            $product = ProductService::getOne($productId);
        } catch (Exception $e) {
            abort(404);
        }
        return view('products.show', compact('product'));
    }

    public function createScreen() {
        $categories = CategoryData::getCategories();
        return view('products.create')->with('categories', $categories);
    }

    public function editScreen(int $productId)
    {
        try {
            $productData = ProductService::getOne($productId);
            $categories = CategoryData::getCategories();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->with('error', 'Во время загрузки что-то пошло не так')
                ->withInput();
        }
        return view('products.edit')->with('product', $productData)->with('categories', $categories);
    }

    public function store(Request $request, ?int $productId = null)
    {
        try {
            $productId ? ProductService::update($request, $productId) : ProductService::create($request);

            return redirect()->route('products.index')
                ->with('success', 'Продукт успешно' . ($productId ? 'обновлён' : 'создан') . '!');
        } catch (Exception $e) {
            Log::error('Ошибка во время создания или обновления продукта: ' . $e->getMessage());
            return back()
                ->with('error', 'Произошла ошибка при ' . ($productId ? 'обновлении' : 'создании') . ' продукта')
                ->withInput();
        }
    }

    public function delete(int $productId) {
        try {
            ProductService::delete($productId);
            return redirect()->route('products.index')
                ->with('success', 'Продукт успешно удален!');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->with('error', 'Произошла ошибка при удалении продукта')
                ->withInput();
        }
    }
}
