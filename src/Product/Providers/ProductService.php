<?php

namespace Core\Product\Providers;

use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\Product;
use Core\Product\Models\InventoryData;
use Core\Product\Models\InventoryItemData;
use Core\Product\Models\ProductData;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class ProductService
{

    public function __construct()
    {
    }

    /**
     * @return array|Collection
     */
    public function all(): array|Collection
    {
        return ProductData::collect(Product::all());
    }

    /**
     * @param int $id
     * @return ProductData
     * @throws ModelNotFoundException<Product>
     */
    public function find(int $id): ProductData
    {
        return ProductData::fromModel(Product::findOrFail($id));
    }

    public function create(array $data): ProductData
    {
        $product = ProductData::fromArray($data)->toModel();
        $product->save();
        $product->inventory()->create([
            'quantity' => 0,
        ]);
        return ProductData::fromModel($product);
    }

    /**
     * @param int $productId
     * @return InventoryData
     * @throws ModelNotFoundException<Inventory>
     */
    public function inventory(int $productId): InventoryData
    {
        return InventoryData::fromModel(Product::findOrFail($productId)->inventory);
    }

    /**
     * @param int $productId
     * @param array $data
     * @return InventoryData
     * @throws ModelNotFoundException<Inventory>
     */
    public function updateInventory(int $productId, array $data): InventoryData
    {
        $inventory = Product::findOrFail($productId)->inventory;
        $inventory->update($data);
        return InventoryData::fromModel($inventory);
    }

    /**
     * @param int $id
     * @param array $data
     * @return ProductData
     * @throws ModelNotFoundException<Product>
     */
    public function update(int $id, array $data): ProductData
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return ProductData::fromModel($product);
    }

    /**
     * @param int $productId
     * @return bool
     * @throws ModelNotFoundException<Inventory>
     */
    public function deleteInventory(int $productId): bool
    {
        return Product::findOrFail($productId)->inventory->delete();
    }

    /**
     * @param int $id
     * @return bool
     * @throws ModelNotFoundException<Product>
     */
    public function delete(int $id): bool
    {
        return Product::findOrFail($id)->delete();
    }

    /**
     * @param int $productId
     * @param array $data
     * @return InventoryData
     * @throws ModelNotFoundException<Product>
     * @throws ModelNotFoundException<Inventory>
     */
    public function createInventory(int $productId, array $data): InventoryData
    {
        $inventory = InventoryData::fromArray($data)->toModel();
        Product::findOrFail($productId)->inventory()->save($inventory);
        return InventoryData::fromModel($inventory);
    }

    /**
     * @param int $productId
     * @return Collection
     */
    public function allInventoryItems(int $productId): Collection
    {
        $inventory = Product::findOrFail($productId)->inventory;
        return InventoryItemData::collect(items: $inventory->items()->get());
    }

    /**
     * @param int $itemId
     * @return InventoryItemData
     * @throws ModelNotFoundException<InventoryItem>
     */
    public function findInventoryItem(int $itemId): InventoryItemData
    {
        return InventoryItemData::fromModel(InventoryItem::findOrFail($itemId));
    }

    /**
     * @param int $inventoryId
     * @param array $data
     * @return InventoryItemData
     * @throws ModelNotFoundException<Inventory>
     * @throws ModelNotFoundException<InventoryItem>
     */
    public function createInventoryItem(int $inventoryId, array $data): InventoryItemData
    {
        $inventory = Inventory::findOrFail($inventoryId);
        $product = $inventory->product;
        $item = InventoryItemData::fromArray([
            ...$data,
            'product_id' => $inventory->product_id,
            'inventory_id' => $inventory->id,
        ])->toModel();
        $inventory->items()->save($item);
        $total_quantity = 0;
        foreach($inventory->items as $item) {
            $total_quantity += $item->quantity;
        }
        $inventory->quantity = $total_quantity;
        $inventory->save();
        $product->quantity = $total_quantity;
        $product->save();
        return InventoryItemData::fromModel($item);
    }

    /**
     * @param int $itemId
     * @param int $quantity
     * @return InventoryItemData
     * @throws ModelNotFoundException<InventoryItem>
     */
    public function updateInventoryItemQuantity(int $itemId, int $quantity): InventoryItemData
    {
        $item = InventoryItem::findOrFail($itemId);
        $item->update(['quantity' => $quantity]);
        return InventoryItemData::fromModel($item);
    }
}
