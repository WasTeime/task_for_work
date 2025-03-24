<?php

namespace App\Http\Services;

use App\Data\OrderData;
use App\Data\OrderItemData;
use App\Data\ProductData;
use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    /**
     * @throws Exception
     */
    public static function create(Request $request)
    {
        $orderItems = [];
        $productsToUpdate = [];

        foreach ($request->cart as $item) {
            try {
                $product = Product::findOrFail($item['id']);

                $orderItemData = OrderItemData::validateAndCreate([
                    'product' => ProductData::fromModel($product)->toArray(),
                    'quantity' => $item['quantity'],
                    'price' => $item['quantity'] * $item['price']
                ]);

                $orderItems[] = $orderItemData->toArray();

                // Сохраняем продукт и количество для последующего обновления
                $productsToUpdate[] = [
                    'product' => $product,
                    'quantity' => $orderItemData->quantity,
                ];
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        try {
            // Создаем OrderData
            $orderData = OrderData::validateAndCreate([
                'status' => 'new',
                'user_id' => Auth::id(),
                'items' => $orderItems,
                'comment' => $request->comment,
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        foreach ($productsToUpdate as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];

            $product->quantity -= $quantity;
            $product->save();
        }

        $order = new Order();
        $order->fill($orderData->toArray());
        $order->save();

        foreach ($productsToUpdate as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];

            $order->products()->attach($product->id, [
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        return $order->id;
    }

    /**
     * @throws Exception
     */
    public static function update(Request $request, int $orderId)
    {
        try {
            $order = Order::findOrFail($orderId);

            $order->status = $request->status ?? $order->status;
            $order->comment = $request->comment ?? $order->comment;

            if ($request->has('cart')) {
                $order->products()->detach();

                foreach ($request->cart as $item) {
                    $product = Product::findOrFail($item['id']);
                    $order->products()->attach($product->id, [
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }
            }

            $order->save();

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public static function delete(int $orderId)
    {
        try {
            $order = Order::findOrFail($orderId);

            // Возвращаем количество товаров на склад
            foreach ($order->products as $product) {
                $product->quantity += $product->pivot->quantity;
                $product->save();
            }

            $order->products()->detach();
            $order->delete();

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public static function getOne(int $orderId)
    {
        try {
            $order = Order::with('products')->findOrFail($orderId);
            return OrderData::fromModel($order);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public static function getAll()
    {
        try {
            $orders = Order::with('products')->get();
            return OrderData::collection($orders);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
