<?php

namespace App\Data;

use App\Models\Order;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Carbon\Carbon;

#[MapName(SnakeCaseMapper::class)]
class OrderData extends Data
{
    public function __construct(
        public ?int $id = null,
        public int $userId,
        public string $status,
        #[DataCollectionOf(OrderItemData::class)]
        public DataCollection $items,
        public ?string $comment = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
    ) {}

    public static function fromModel(Order $order): self
    {
        $items = $order->products->map(function ($product) {
            return new OrderItemData(
                product: ProductData::fromModel($product),
                quantity: $product->pivot->quantity,
                price: $product->pivot->price,
            );
        });

        return new self(
            id: $order->id,
            userId: $order->user_id,
            status: $order->status->value,
            items: new DataCollection(OrderItemData::class, $items->toArray()),
            comment: $order->comment,
            createdAt: $order->created_at,
            updatedAt: $order->updated_at,
        );
    }
}
