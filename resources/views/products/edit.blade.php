<x-app-layout>
    <x-product-form
        :title="__('Изменение товара')"
        :textOnSubmitBtn="__('Сохранить изменения')"
        :categories="$categories"
        :action="route('products.update', $product->id)"
        :product="$product"
    />
</x-app-layout>