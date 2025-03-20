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
                <x-admin.card title="Пользователи" href="{{ route('admin.users') }}">
                    <div class="text-3xl font-bold text-gray-700">
                        {{ $usersCount ?? 0 }}
                    </div>
                </x-admin.card>

                <!-- Карточка продуктов -->
                <x-admin.card title="Продукты" href="{{ route('products') }}">
                    <div class="text-3xl font-bold text-gray-700">
                        {{ $productsCount ?? 0 }}
                    </div>
                </x-admin.card>

                <!-- Карточка заказов -->
{{--                <x-admin.card title="Продукты" href="{{ route('orders') }}">--}}
{{--                    <div class="text-3xl font-bold text-gray-700">--}}
{{--                        {{ $ordersCount ?? 0 }}--}}
{{--                    </div>--}}
{{--                </x-admin.card>--}}
            </div>
        </div>
    </div>
</x-app-layout>
