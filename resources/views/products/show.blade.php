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
                        <!-- Изображение товара -->
                        <div class="relative">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full rounded-lg shadow-md">
                            @if($product->stock > 0)
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
                                        <span class="text-gray-600">Артикул:</span>
                                        <span class="font-medium">{{ $product->sku }}</span>
                                    </li>
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Категория:</span>
                                        <span class="font-medium">{{ $product->category }}</span>
                                    </li>
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Производитель:</span>
                                        <span class="font-medium">{{ $product->manufacturer }}</span>
                                    </li>
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">В наличии:</span>
                                        <span class="font-medium">{{ $product->stock }} шт.</span>
                                    </li>
                                </ul>
                            </div>

                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-6">
                                    @csrf
                                    <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                                        Добавить в корзину
                                    </button>
                                </form>
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
</x-app-layout> 