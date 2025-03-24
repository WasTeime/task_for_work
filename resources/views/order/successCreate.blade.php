<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-20">
        <div class="w-full max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6 mt-20 pt-20 space-y-6">
            <!-- Иконка успеха -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-6 mx-auto">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Заголовок -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    Заказ успешно оформлен!
                </h1>

                <!-- Номер заказа -->
                <p class="text-gray-600 text-lg">
                    Номер вашего заказа: <span class="font-medium">{{ $orderId }}</span>
                </p>
            </div>

            <!-- Сообщение -->
            <div class="mb-8 text-center">
                <p class="text-gray-700 text-lg" style="word-spacing: 0.5rem;">
                    Наш менеджер свяжется с вами в ближайшее время для подтверждения заказа.
                </p>
            </div>

            <!-- Кнопка "Вернуться на главную" -->
            <div class="mt-10 text-center">
                <a href="/" class="inline-flex items-center justify-center bg-blue-600 text-white px-8 py-3 mx-5 rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-lg font-medium">
                    Вернуться на главную
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
