<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;

class OrderData extends Data
{
    public function __construct(
        public int $id,
        public UserData $user,
        public string $status,
        public ?string $comment = null,
        #[DataCollectionOf(OrderItemData::class)]
        public DataCollection $items,
    ) {}
} 