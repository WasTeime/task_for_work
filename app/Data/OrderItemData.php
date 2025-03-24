<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class OrderItemData extends Data
{
    public function __construct(
        public ProductData $product,
        //количество в заказе
        public int $quantity,
        public float $price,
    ) {}
}
