<?php

namespace App\Data;

use App\Models\Category;
use Spatie\LaravelData\Data;

class CategoryData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}

    public static function fromModel(Category $category): self
    {
        return new self(
            id: $category->id,
            name: $category->name
        );
    }

    public static function fromId(int $categoryId): self
    {
        $category = Category::findOrFail($categoryId);
        return new self(
            id: $category->id,
            name: $category->name
        );
    }

    public static function getCategories(): array
    {
        $categories = [];
        foreach (Category::getAll() as $category) {
            $categories[] = new CategoryData($category->id, $category->name);
        }
        return $categories;
    }
}
