<?php

namespace Core\Product\Livewire;

use App\Models\InventoryItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class InventoryItemForm extends Component
{
    use WithFileUploads;

    public bool $show = false;
    public string $label = 'Create';
    public $form = [];

    public function mount($item, $product, $inventory, $label = 'create'): void
    {
        $this->form = $item ? $item->toArray() : $this->createNewItem($product, $inventory);
        $this->label = $label;
    }

    private function createNewItem($product, $inventory): array
    {
        return [
            'product_id' => $product->id,
            'inventory_id' => $inventory->id,
            'sku' => $this->generateSKU($inventory->id),
            'barcode' => $this->generateBarcode($inventory->id, $product->id),
            'purchase_price' => 0.0,
            'sell_price' => 0.0,
            'quantity' => 0,
            'size' => 'M',
            'color' => '#000000',
            'image' => '',
        ];
    }

    public function saveItem(): void
    {
        $validated = $this->validateForm();

        if ($item = InventoryItem::find($this->form['id'] ?? null)) {
            $item = $this->updateItem($item);
        } else {
            $item = $this->createItem();
        }

        if ($this->updateInventory($item)) {
            $this->show = false;
            session()->flash('success', 'Inventory item saved successfully');
        } else {
            session()->flash('error', 'Failed to update inventory');
        }

        $this->redirect(route('admin.product.edit', $this->form['product_id']));
    }

    /**
     * @return array
     *
     * @throws ValidationException
     */
    private function validateForm(): array
    {
        return $this->validate([
            'form.sku' => 'required',
            'form.barcode' => 'required',
            'form.purchase_price' => 'required',
            'form.sell_price' => 'required',
            'form.quantity' => 'required',
            'form.size' => 'required',
            'form.color' => 'required',
            'form.image' => 'required',
        ], [
            'form.sku.required' => __('SKU is required'),
            'form.barcode.required' => __('Barcode is required'),
            'form.purchase_price.required' => __('Purchase price is required'),
            'form.sell_price.required' => __('Sell price is required'),
            'form.quantity.required' => __('Quantity is required'),
            'form.size.required' => __('Size is required'),
            'form.color.required' => __('Color is required'),
            'form.image.required' => __('Image is required'),
        ]);
    }

    private function updateItem($item): InventoryItem
    {
        $this->form['image'] = $this->updateImage($item);
        $item->update($this->form);
        return $item;
    }

    private function updateImage($item): string
    {
        if ($item->image != $this->form['image']) {
            return $this->storeImage();
        }

        return $item->image;
    }

    private function createItem(): InventoryItem
    {
        $this->form['image'] = $this->storeImage();
        return InventoryItem::create($this->form);
    }

    private function storeImage(): string
    {
        $path = $this->form['image']->store('public/products/'. $this->form['product_id'] .'/inventory-items');
        return Storage::url($path);
    }

    public function generateBarcode($inventoryId, $productId): string
    {
        return 'BC-' . str_pad($inventoryId, 5, '0', STR_PAD_LEFT) . '-' . str_pad($productId, 5, '0', STR_PAD_LEFT) . '-' . rand(100, 999);
    }

    public function generateSKU($inventoryId): string
    {
        return 'SKU-' . str_pad($inventoryId, 5, '0', STR_PAD_LEFT) . '-' . rand(100, 999);
    }

    public function updateInventory(InventoryItem $item): bool
    {
        $inventory = $item->inventory;
        return $inventory->update([
            'quantity' => $inventory->items->sum('quantity'),
        ]);
    }

    public function render(): View
    {
        return view('admin.Inventory.Item.form');
    }
}
