<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Админская панель') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Карточка пользователей -->
                <x-card title="Пользователи" href="{{ route('users') }}">
                    <div class="text-3xl font-bold text-gray-700">
                        {{ $usersCount ?? 0 }}
                    </div>
                </x-card>

                <!-- Карточка продуктов -->
                <x-card title="Продукты" href="{{ route('products.index') }}">
                    <div class="text-3xl font-bold text-gray-700">
                        {{ $productsCount ?? 0 }}
                    </div>
                </x-card>

                <!-- Карточка заказов -->
                <x-card title="Заказы" href="{{ route('orders.index') }}">
                    <div class="text-3xl font-bold text-gray-700">
                        {{ $ordersCount ?? 0 }}
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
