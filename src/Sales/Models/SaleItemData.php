<?php

namespace Core\Sales\Models;

use App\Models\SaleItem;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;

class SaleItemData extends Data
{

    public function __construct(
        public ?int $id,
        public int $sale_id,
        public int $inventory_item_id,
        public ?int $quantity = 1,
        public ?float $price = 0,
        public ?float $discount_amount = 0,
        public ?float $total_amount = 0,
    ){}

    public static function fromArray(array $inputs): SaleItemData
    {
        return new self(
            id: $inputs['id'] ?? null,
            sale_id: $inputs['sale_id'],
            inventory_item_id: $inputs['inventory_item_id'],
            quantity: $inputs['quantity'] ?? 1,
            price: $inputs['price'] ?? 0,
            discount_amount: $inputs['discount_amount'] ?? 0,
            total_amount: $inputs['total_amount'] ?? 0,
        );
    }

    public static function fromModel($model): SaleItemData
    {
        return new self(
            id: $model->id,
            sale_id: $model->sale_id,
            inventory_item_id: $model->inventory_item_id,
            quantity: $model->quantity,
            price: $model->price,
            discount_amount: $model->discount_amount,
            total_amount: $model->total_amount,
        );
    }

    public function toModel(): SaleItem|Model
    {
        if ($this->id) {
            $saleItem = SaleItem::findOrFail($this->id);
        }else {
            $saleItem = new SaleItem();
        }

        $saleItem->fill([
            'sale_id' => $this->sale_id,
            'inventory_item_id' => $this->inventory_item_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'discount_amount' => $this->discount_amount,
            'total_amount' => $this->total_amount,
        ]);

        return $saleItem;
    }

}
