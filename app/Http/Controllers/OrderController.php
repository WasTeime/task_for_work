<?php

namespace App\Http\Controllers;


use App\Enums\OrderStatus;
use App\Http\Services\OrderService;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Отображение списка заказов.
    */
    public function index()
    {
        // Получаем все заказы с продуктами
        $orders = Order::with('products')->paginate(10);

        // Передаем заказы в шаблон
        return view('order.index', compact('orders'));
    }

    /**
     * Отображение деталей заказа.
     */
    public function show($orderId)
    {
        try {
            // Получаем данные заказа через сервис
            $order = OrderService::getOne($orderId);

            Log::info(print_r($order, true));
            // Передаем заказ в шаблон
            return view('order.show', compact('order'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('orders.index')->with('error', 'Не удалось загрузить данные заказа.');
        }
    }

    /**
     * Отображение страницы успешного создания заказа.
     */
    public function createSuccess($orderId)
    {
        return view('order.successCreate')->with(['orderId' => $orderId]);
    }

    /**
     * Создание нового заказа.
     */
    public function create(Request $request)
    {
        try {
            $orderId = OrderService::create($request);
            return response()->json([
                'success' => true,
                'orderId' => $orderId,
                'redirectUrl' => route('orders.success', ['orderId' => $orderId])
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Не удалось оформить заказ'], 500);
        }
    }

    /**
     * Отображение формы редактирования заказа.
     */
    public function editScreen($orderId)
    {
        try {
            // Получаем данные заказа через сервис
            $order = OrderService::getOne($orderId);

            // Передаем заказ в шаблон
            return view('order.edit', compact('order'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('orders.index')->with('error', 'Не удалось загрузить данные заказа.');
        }
    }

    /**
     * Обновление заказа.
     */
    public function edit(Request $request, $orderId)
    {
        try {
            OrderService::update($request, $orderId);

            return redirect()->route('orders.index');
//            return response()->json([
//                'success' => true,
//                'message' => 'Заказ успешно обновлен!',
//                'redirectUrl' => route('orders.index')
//            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response('Не удалось удалить заказ');
//            return response()->json(['success' => false, 'message' => 'Не удалось обновить заказ'], 500);
        }
    }

    /**
     * Удаление заказа.
     */
    public function delete($orderId)
    {
        try {
            // Удаляем заказ через сервис
            OrderService::delete($orderId);

            return redirect()->route('orders.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response('Не удалось удалить заказ');
        }
    }

    public function markAsDelivered(int $orderId)
    {
        try {
            $order = Order::findOrFail($orderId);

            $order->status = OrderStatus::DELIVERED->value;
            $order->save();

            Log::info('Заказ обновлен:', ['order' => $order]);

            return redirect()->route('orders.index')
                ->with('success', 'Заказ успешно отмечен как доставленный!');
        } catch (Exception $e) {
            Log::error('Ошибка при обновлении заказа:', ['error' => $e->getMessage()]);
            return redirect()->route('orders.index')
                ->with('error', 'Не удалось обновить статус заказа.');
        }
    }
}
