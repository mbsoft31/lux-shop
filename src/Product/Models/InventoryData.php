<?php

namespace Core\Product\Models;

use App\Models\Inventory;
use Exception;
use Spatie\LaravelData\Data;

class InventoryData extends Data
{
    public function __construct(
        public ?int $id,
        public int $quantity,
    ){}

    public static function fromArray(array $data): InventoryData
    {
        return new InventoryData(
            id: $data['id'] ?? null,
            quantity: $data['quantity'],
        );
    }

    public static function fromModel($model): InventoryData
    {
        return new InventoryData(
            id: $model->id,
            quantity: $model->quantity,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
        ];
    }

    /**
     * @throws Exception
     */
    public function toModel(): Inventory
    {
        if ($this->id !== null) {
            $inventory = Inventory::find($this->id);
            if (!$inventory) {
                throw new Exception('Inventory not found');
            }
        } else {
            $inventory = new Inventory();
            $inventory->id = $this->id;
            $inventory->quantity = $this->quantity;
        }
        return $inventory;
    }
}
