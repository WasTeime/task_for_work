@php use App\Enums\OrderStatus; @endphp
<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Список заказов</h1>

        <!-- Таблица заказов -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <!-- Заголовок таблицы -->
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                        заказа
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                        пользователя
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата
                        заказа
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Количество товаров
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Действия
                    </th>
                </tr>
                </thead>

                <!-- Тело таблицы -->
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($orders as $order)
                    <tr>
                        <!-- ID заказа -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $order->id }}
                        </td>

                        <!-- ID пользователя -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->user_id }}
                        </td>

                        <!-- Дата заказа -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('d.m.Y H:i') }}
                        </td>

                        <!-- Количество товаров -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->products->count() }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 text-sm font-semibold rounded-full
                                    {{ $order->status == OrderStatus::NEW ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $order->status }}
                                </span>
                        </td>

                        <!-- Действия -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900">Просмотр</a>
                            <a href="{{ route('orders.edit', $order->id) }}"
                               class="ml-2 text-indigo-600 hover:text-indigo-900">Редактировать</a>
                            <form action="{{ route('orders.delete', $order->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="ml-2 text-red-600 hover:text-red-900">Удалить</button>
                            </form>

                            <!-- Кнопка "Отметить как выполненный" -->
                            @if ($order->status === OrderStatus::NEW)
                                <form action="{{ route('orders.markAsDelivered', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="ml-2 text-green-600 hover:text-green-900">
                                        Доставлен
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
