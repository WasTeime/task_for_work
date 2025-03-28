<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->name }}
            </h2>
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Назад к списку
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="relative">
                            <img src="https://placehold.co/600x400" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow-md">
                            @if($product->quantity > 0)
                                <span class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                                    В наличии
                                </span>
                            @else
                                <span class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm">
                                    Нет в наличии
                                </span>
                            @endif
                        </div>

                        <!-- Информация о товаре -->
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                            <div class="mb-6">
                                <span class="text-3xl font-bold text-gray-900">{{ number_format($product->price, 2) }} ₽</span>
                            </div>

                            <div class="mb-6">
                                <h2 class="text-lg font-semibold text-gray-800 mb-2">Описание</h2>
                                <p class="text-gray-600">{{ $product->description }}</p>
                            </div>

                            <div class="mb-6">
                                <h2 class="text-lg font-semibold text-gray-800 mb-2">Характеристики</h2>
                                <ul class="space-y-2">
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Категория:</span>
                                        <span class="font-medium">{{ $product->category->name }}</span>
                                    </li>
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">В наличии:</span>
                                        <span class="font-medium">{{ $product->quantity }} шт.</span>
                                    </li>
                                </ul>
                            </div>

                            @if($product->quantity > 0)
                                <div class="product-id" id="{{$product->id}}"></div>
                                <div id="cart-container-{{ $product->id }}">
                                    <!-- Кнопка "Добавить в корзину" -->
                                    <button
                                        type="submit"
                                        onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{$product->quantity}})"
                                        class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                        id="add-to-cart-button-{{ $product->id }}"
                                    >
                                        Добавить в корзину
                                    </button>

                                    <!-- Контейнер для кнопок изменения количества -->
                                    <div id="quantity-buttons-{{ $product->id }}" style="display: none;" class="flex items-center justify-center space-x-4 mt-2">
                                        <button
                                            onclick="changeQuantity({{ $product->id }}, -1)"
                                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                        >
                                            -
                                        </button>
                                        <span id="product-quantity-{{ $product->id }}" class="text-lg font-medium text-gray-700">1</span>
                                        <button
                                            onclick="changeQuantity({{ $product->id }}, 1)"
                                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>
                            @else
                                <button disabled class="w-full bg-gray-400 text-white px-6 py-3 rounded-lg cursor-not-allowed">
                                    Товар отсутствует
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        @vite('resources/js/functional/cart/moreAndLessButtonsForAddToCart')
    </x-slot>
</x-app-layout>
