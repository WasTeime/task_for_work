<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Корзина</h1>

        <!-- Список товаров в корзине -->
        <div id="cart-items" class="space-y-4">
            <!-- Товары будут добавлены сюда динамически -->
        </div>

        <!-- Общая стоимость -->
        <div class="mt-8 border-t pt-4">
            <p class="text-xl font-semibold">Итого: <span id="cart-total">0</span> руб.</p>
        </div>

        <div class="mt-6">
            <label for="order-comment" class="block text-sm font-medium text-gray-700">Комментарий к заказу</label>
            <textarea
                id="order-comment"
                name="order-comment"
                rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                placeholder="Например, укажите удобное время доставки или дополнительные пожелания..."
            ></textarea>
        </div>

        <!-- Кнопка "Оформить заказ" -->
        <div class="mt-6">
            <button
                onclick="checkout()"
                class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Оформить заказ
            </button>
        </div>
    </div>

    <x-slot name="scripts">
        @vite('resources/js/pages/cartPage')
    </x-slot>
</x-app-layout>
