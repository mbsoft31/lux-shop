<?php

namespace Core\Product\Models;

use App\Models\Product;
use Core\Product\Traits\DataHasMeta;
use Spatie\LaravelData\Data;

class ProductData extends Data
{
    use DataHasMeta;

    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $description = "",
        public float $purchase_price = 0,
        public float $sell_price = 0,
        public int $quantity = 0,
        public ?string $image = null,
        array $meta = [],
    )
    {
        $this->meta = $meta;
    }

    public static function fromArray(array $data): ProductData
    {
        return new ProductData(
            id: $data['id'] ?? null,
            name: $data['name'],
            description: $data['description'] ?? null,
            purchase_price: $data['purchase_price'] ?? 0,
            sell_price: $data['sell_price'] ?? 0,
            quantity: $data['quantity'] ?? 0,
            image: $data['image'] ?? null,
            meta: $data['meta'],
        );
    }

    public static function fromModel($model): ProductData
    {
        return new ProductData(
            id: $model->id,
            name: $model->name,
            description: $model->description,
            purchase_price: $model?->purchase_price ?? 0,
            sell_price: $model?->sell_price ?? 0,
            quantity: $model?->quantity ?? 0,
            image: $model->image,
            meta: $model->meta,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'purchase_price' => $this->purchase_price,
            'sell_price' => $this->sell_price,
            'quantity' => $this->quantity,
            'image' => $this->image,
            'meta' => $this->meta,
        ];
    }

    public function toModel(): Product
    {
        if ($this->id) {
            $product = Product::find($this->id);
        } else {
            $product = new Product();
        }
        $product->fill([
            'name' => $this->name,
            'description' => $this->description,
            'purchase_price' => $this->purchase_price,
            'sell_price' => $this->sell_price,
            'quantity' => $this->quantity,
            'image' => $this->image,
            'meta' => $this->meta,
        ]);
        return $product;
    }

    public static function metaConfig(): array
    {
        return static::$metaConfig = [
            'type' => [
                'label' => __('Type'),
                'type' => 'select',
                'options' => [
                    'clothing' => __('Clothing'),
                    'footwear' => __('Footwear'),
                    'underwear' => __('Underwear'),
                    'outerwear' => __('Outerwear'),
                ],
                'required' => true,
                'default' => 'clothing',
            ],
            'size_type' => [
                'type' => 'select',
                'label' => __('Size Type'),
                'options' => [
                    'char' => 'Character',
                    'numeric' => 'Numeric',
                ],
                'required' => true,
                'default' => 'char',
            ],
            'size' => [
                'type' => 'select',
                'label' => __('Size'),
                'options' => [],
                'required' => false,
            ],
            'brand' => [
                'type' => 'text',
                'label' => __('Brand'),
                'required' => false,
            ],
            'material' => [
                'type' => 'text',
                'label' => __('Material'),
                'required' => false,
            ],
            'style' => [
                'type' => 'text',
                'label' => __('Style'),
                'required' => false,
            ],
            'is_best_seller' => [
                'type' => 'checkbox',
                'label' => __('Best Seller'),
                'required' => false,
            ],
            'is_new' => [
                'type' => 'checkbox',
                'label' => __('New'),
                'required' => false,
                'default' => true,
            ],
            'is_featured' => [
                'type' => 'checkbox',
                'label' => __('Featured'),
                'required' => false,
            ],
        ];
    }

}
