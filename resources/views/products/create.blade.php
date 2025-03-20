<x-app-layout>
    <x-product-form
        :title="__('Создание товара')"
        :textOnSubmitBtn="__('Создать товар')"
        :categories="$categories"
        :action="route('products.store')"
    />
</x-app-layout>