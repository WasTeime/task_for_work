<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class OrderItemData extends Data
{
    public function __construct(
        public ProductData $product,
        public int $quantity,
        public float $price,        
    ) {}
} 