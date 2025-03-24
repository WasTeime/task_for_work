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
            <h1 class="text-2xl font-bold">Редактирование заказа #{{ $order->id }}</h1>
        </div>


        <form action="{{ route('orders.edit', $order->id) }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf

            <!-- Статус заказа -->
            <div class="mb-4">
                <label for="status" class="block text-gray-600">Статус:</label>
                <select name="status" id="status" class="w-full p-2 border rounded-lg">
                    <option value="new" {{ $order->status === 'new' ? 'selected' : '' }}>Новый</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Доставлен</option>
                </select>
            </div>

            <!-- Комментарий -->
            <div class="mb-4">
                <label for="comment" class="block text-gray-600">Комментарий:</label>
                <textarea name="comment" id="comment" class="w-full p-2 border rounded-lg">{{ $order->comment }}</textarea>
            </div>

            <!-- Список товаров в заказе -->
            <div class="mt-8">
                <h2 class="text-xl font-bold mb-4">Товары в заказе</h2>
                <ul class="space-y-4">
                    @foreach ($order->items as $item)
                        <li class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-900 font-medium">{{ $item->product->name }}</p>
                            <p class="text-gray-600">Количество: {{ $item->quantity }}</p>
                            <p class="text-gray-600">Цена за единицу: {{ $item->price }} руб.</p>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Кнопки -->
            <div class="mt-6 flex items-center gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Сохранить изменения
                </button>
                <a href="{{ route('orders.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Отмена
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
