<?php

namespace App\Http\Services;

use App\Data\ProductData;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelData\DataCollection;

class ProductService {

    public static function getAll(): DataCollection
    {
        return ProductData::collection(Product::all());
    }

    /**
     * @throws Exception
     */
    public static function getOne($productId): ProductData
    {
        try {
            $product = Product::with('category')->findOrFail($productId);
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception($e);
        }
        return ProductData::fromModel($product);
    }

    /**
     * @throws Exception
     */
    private static function fillModel(Request $request, Product $product): Product
    {
        try {
            $productData = ProductData::fromRequest($request);
            $product->fill($productData->toArray());
            $product->category_id = $productData->category->id;
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception($e->getMessage());
        }
        return $product;
    }

    /**
     * Возвращает ответ true/false - успешно ли сохранёно в бд
     *
     * @throws Exception
     */
    public static function create(Request $request): bool
    {
        try {
            $product = new Product();
            $product = self::fillModel($request, $product);
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception($e);
        }
        return $product->save();
    }

    /**
     * Возвращает ответ true/false - успешно ли сохранёно в бд
     *
     * @throws Exception
     */
    public static function update(Request $request, int $productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $product = self::fillModel($request, $product);
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception($e);
        }
        return $product->save();
    }

    /**
     * Возвращает ответ true/false - успешно ли удалено из бд
     *
     * @throws Exception
     */
    public static function delete($productId): bool {
        try {
            $product = Product::findOrFail($productId);
            return $product->delete();
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception($e);
        }
    }
}
