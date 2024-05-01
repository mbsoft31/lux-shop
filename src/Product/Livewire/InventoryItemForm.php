<?php

namespace Core\Product\Livewire;

use App\Models\InventoryItem;
use App\Models\Product;
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

    public Product $product;
    public $form = [];

    public function mount($item, $product, $inventory, $label = 'Create'): void
    {
        $this->product = $product;
        $this->form = $item ? $item->toArray() : $this->createNewItem($product, $inventory);
        $this->label = $label;
    }

    private function createNewItem($product, $inventory): array
    {
        return [
            'product_id' => $product->id,
            'inventory_id' => $inventory->id,
            'barcode' => $this->generateBarcode($inventory->id, $product->id),
            'quantity' => 0,
            'image' => '',
            'meta' => [
                'size' => 'M',
                'color' => '#000000',
            ]
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

        $this->redirect(route('admin.products.edit', $this->form['product_id']));
    }

    /**
     * @return array
     *
     * @throws ValidationException
     */
    private function validateForm(): array
    {
        return $this->validate([
            'form.barcode' => 'required',
            'form.quantity' => 'required',
            'form.image' => 'nullable',
            'form.meta.size' => 'required',
            'form.meta.color' => 'required',
        ], [
            'form.barcode.required' => __('Barcode is required'),
            'form.quantity.required' => __('Quantity is required'),
            'form.image.nullable' => __('Image is optional'),
            'form.meta.size.required' => __('Size is required'),
            'form.meta.color.required' => __('Color is required'),
        ]);
    }

    private function updateItem($item): InventoryItem
    {
        $item->update($this->form);
        return $item;
    }

    private function createItem(): InventoryItem
    {
        return InventoryItem::create($this->form);
    }

    public function generateBarcode($inventoryId, $productId): string
    {
        return 'BC-' . str_pad($inventoryId, 5, '0', STR_PAD_LEFT) . '-' . str_pad($productId, 5, '0', STR_PAD_LEFT) . '-' . rand(100, 999);
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
        $sizes = [
            "char" => [
                "XS" => "Extra Small",
                "S" => "Small",
                "M" => "Medium",
                "L" => "Large",
                "XL" => "Extra Large",
                "XXL" => "Double Extra Large",
            ],
            "numeric" => range(36, 46),
        ];
        $sizeType = $this->product->meta['size_type'];
        return view('admin.Inventory.Item.form', [
            "sizes" => $sizes[$sizeType]
        ]);
    }
}
