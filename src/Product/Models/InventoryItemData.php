<?php

namespace Core\Product\Models;

use App\Models\InventoryItem;
use App\Models\Product;
use Core\Product\Traits\DataHasMeta;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\LaravelData\Data;

class InventoryItemData extends Data
{

    use DataHasMeta;

    public function __construct(
        public ?int $id,
        public ?string $barcode,
        public int $product_id,
        public int $inventory_id,
        public int $quantity,
        public ?string $image,
        array $meta = [],
    ){
        $this->meta = $meta;
    }

    public function product(): ProductData
    {
        return ProductData::fromModel(Product::findOrFail($this->product_id));
    }

    public static function fromArray(array $data): InventoryItemData
    {
        return new InventoryItemData(
            id: $data['id'] ?? null,
            barcode: $data['barcode'] ?? null,
            product_id: $data['product_id'],
            inventory_id: $data['inventory_id'],
            quantity: $data['quantity'],
            image: $data['image'] ?? null,
            meta: $data['meta'] ?? [],
        );
    }

    public static function fromModel(InventoryItem $model): InventoryItemData
    {
        return new InventoryItemData(
            id: $model->id,
            barcode: $model->barcode,
            product_id: $model->product_id,
            inventory_id: $model->inventory_id,
            quantity: $model->quantity,
            image: $model->image,
            meta: $model->meta,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'barcode' => $this->barcode,
            'product_id' => $this->product_id,
            'inventory_id' => $this->inventory_id,
            'quantity' => $this->quantity,
            'image' => $this->image,
            'meta' => $this->meta,
        ];
    }

    /**
     * @throws ModelNotFoundException<InventoryItem>
     */
    public function toModel(): InventoryItem
    {
        if ($this->id !== null) {
            $inventory = InventoryItem::findOrFail($this->id);
        } else {
            // generate a barcode if not provided
            if (!$this->barcode) {
                $this->barcode = 'INV' . str_pad(InventoryItem::count() + 1, 6, '0', STR_PAD_LEFT);
            }
            $inventory = new InventoryItem();
            $inventory->barcode = $this?->barcode ?? null;
            $inventory->product_id = $this->product_id;
            $inventory->inventory_id = $this->inventory_id;
            $inventory->quantity = $this?->quantity ?? 0;
            $inventory->image = $this?->image ?? null;
            $inventory->meta = $this?->meta ?? [];
        }
        return $inventory;
    }

    public function metaConfig(): array
    {
        return $this->metaConfig = [
            'size' => [
                'type' => 'select',
                'label' => __('Size'),
                'options' => [],
                'required' => true,
            ],
            'color' => [
                'type' => 'color',
                'label' => __('Color'),
                'required' => true,
                'default' => '#000000',
            ],
        ];
    }

}
