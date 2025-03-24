<?php

namespace App\Data;

use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class ProductData extends Data
{
    public function __construct(
      public ?int $id = null,
      public string $name,
      public ?string $description,
      public float $price,
      //количество на складе
      public int $quantity,
      public ?CategoryData $category,
    ) {}

    public static function fromModel(Product $product): self
    {
        return new self(
            id: $product->id,
            name: $product->name,
            description: $product->description,
            price: $product->price,
            quantity: $product->quantity,
            category: CategoryData::fromModel($product->category)
        );
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->id ?? null,
            name: $request->name,
            description: $request->description ?? null,
            price: $request->price,
            quantity: $request->quantity,
            category: $request->category ? CategoryData::fromId($request->category) : null
        );
    }
}
