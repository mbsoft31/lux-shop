<?php

namespace Core\Product\Models;

use App\Models\Product;
use Spatie\LaravelData\Data;

class ProductData extends Data
{

    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $description,
    )
    {}

    public static function fromArray(array $data): ProductData
    {
        return new ProductData(
            id: $data['id'] ?? null,
            name: $data['name'],
            description: $data['description'],
        );
    }

    public static function fromModel($model): ProductData
    {
        return new ProductData(
            id: $model->id,
            name: $model->name,
            description: $model->description,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    public function toModel(): Product
    {
        if ($this->id) {
            $product = Product::find($this->id);
        } else {
            $product = new Product();
            $product->fill([
                'name' => $this->name,
                'description' => $this->description,
            ]);
        }
        return $product;
    }
}
