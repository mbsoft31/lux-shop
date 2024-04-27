<?php

namespace Core\Product\Models;

use App\Models\Inventory;
use App\Models\InventoryItem;
use Core\Product\Enums\InventoryItemStatus;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\LaravelData\Data;

class InventoryItemData extends Data
{

    public function __construct(
        public ?int $id,
        public int $product_id,
        public int $inventory_id,
        public float $purchase_price,
        public float $sell_price,
        public int $quantity,
        public ?string $brand,
        public ?string $size,
        public ?string $color,
        public ?string $material,
        public ?string $style,
        public ?string $image,
        public ?string $barcode,
        public ?string $sku,
        public ?string $status = null,
        public ?array $meta = [],
    ){
        $this->status = InventoryItemStatus::tryFrom($status)->value;
    }

    public static function fromArray(array $data): InventoryItemData
    {
        return new InventoryItemData(
            id: $data['id'] ?? null,
            product_id: $data['product_id'],
            inventory_id: $data['inventory_id'],
            purchase_price: $data['purchase_price'],
            sell_price: $data['sell_price'],
            quantity: $data['quantity'],
            brand: $data['brand'] ?? null,
            size: $data['size'] ?? null,
            color: $data['color'] ?? null,
            material: $data['material'] ?? null,
            style: $data['style'] ?? null,
            image: $data['image'] ?? null,
            barcode: $data['barcode'] ?? null,
            sku: $data['sku'] ?? null,
            status: $data['status'] ?? null,
            meta: $data['meta'] ?? [],
        );
    }

    public static function fromModel(InventoryItem $model): InventoryItemData
    {
        return new InventoryItemData(
            id: $model->id,
            product_id: $model->product_id,
            inventory_id: $model->inventory_id,
            purchase_price: $model->purchase_price,
            sell_price: $model->sell_price,
            quantity: $model->quantity,
            brand: $model?->brand,
            size: $model?->size,
            color: $model?->color,
            material: $model?->material,
            style: $model?->style,
            image: $model?->image,
            barcode: $model?->barcode,
            sku: $model?->sku,
            status: $model?->status,
            meta: $model?->meta ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'inventory_id' => $this->inventory_id,
            'quantity' => $this->quantity,
            'size' => $this->size,
            'color' => $this->color,
            'material' => $this->material,
            'style' => $this->style,
            'image' => $this->image,
            'barcode' => $this->barcode,
            'sku' => $this->sku,
            'status' => $this->status,
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
            $inventory = new InventoryItem();
            $inventory->product_id = $this->product_id;
            $inventory->inventory_id = $this->inventory_id;
            $inventory->purchase_price = $this->purchase_price;
            $inventory->sell_price = $this->sell_price;
            $inventory->brand = $this->brand;
            $inventory->quantity = $this->quantity;
            $inventory->size = $this->size;
            $inventory->color = $this->color;
            $inventory->material = $this->material;
            $inventory->style = $this->style;
            $inventory->image = $this->image;
            $inventory->barcode = $this->barcode;
            $inventory->sku = $this->sku;
            $inventory->status = $this->status;
            $inventory->meta = $this->meta;
        }

        return $inventory;
    }


}
