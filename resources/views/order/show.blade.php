@php
    use App\Enums\OrderStatus;
@endphp
<x-app-layout>
    <div class="container mx-auto px-4 py-8 mb-6">
        <div class="flex items-center">
            <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                          clip-rule="evenodd"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold">Детали заказа #{{ $order->id }}</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mt-5">
            <!-- Основная информация о заказе -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <!-- ID пользователя -->
                <div>
                    <p class="text-gray-600">ID пользователя:</p>
                    <p class="text-gray-900 font-medium">{{ $order->userId }}</p>
                </div>

                <!-- Статус заказа -->
                <div>
                    <p class="text-gray-600">Статус:</p>
                    <p class="text-gray-900 font-medium">
                        <span class="px-2 py-1 text-sm font-semibold rounded-full
                            {{ $order->status === 'new' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ $order->status }}
                        </span>
                    </p>
                </div>

                <!-- Дата заказа -->
                <div>
                    <p class="text-gray-600">Дата заказа:</p>
                    <p class="text-gray-900 font-medium">{{ $order->createdAt->format('d.m.Y H:i') }}</p>
                </div>

                <!-- Комментарий -->
                <div>
                    <p class="text-gray-600">Комментарий:</p>
                    <p class="text-gray-900 font-medium">{{ $order->comment ?? 'Нет комментария' }}</p>
                </div>
            </div>

            <!-- Список товаров в заказе -->
            <div class="mt-8">
                <h2 class="text-xl font-bold mb-4">Товары в заказе</h2>
                <ul class="space-y-4">
                    @foreach ($order->items as $item)
                        <li class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-900 font-medium">{{ $item->product->name }}</p>
                            <p class="text-gray-600">Количество: {{ $item->quantity }}</p>
                            <p class="text-gray-600">Цена за единицу: {{ $item->product->price }} руб.</p>
                            <p class="text-gray-600">Общая стоимость: {{ $item->quantity * $item->price }} руб.</p>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Общая сумма заказа -->
            <div class="mt-5">
                <p class="text-gray-600 text-lg">Общая сумма заказа:</p>
                <p class="text-gray-900 font-semibold text-2xl">
                    {{
                        number_format(
                            $order->items->toCollection()->sum(fn($item) => $item->quantity * $item->price),
                            0,
                            ',',
                            ' '
                        )
                    }} руб.
                </p>
            </div>

            <!-- Кнопка "Отметить как доставленный" -->
            <div class="mt-8">
                @if ($order->status === OrderStatus::NEW->value)
                    <form action="{{ route('orders.markAsDelivered', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center justify-center bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                      clip-rule="evenodd"/>
                            </svg>
                            Отметить как доставленный
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
