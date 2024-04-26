<?php

namespace Core\Product\Livewire;

use App\Models\InventoryItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class InventoryItemForm extends Component
{
    use WithFileUploads;

    public $form = [
        'product_id' => null,
        'inventory_id' => null,
        'sku' => null,
        'barcode' => null,
        'purchase_price' => null,
        'sell_price' => null,
        'quantity' => null,
        'size' => null,
        'color' => null,
        'image' => null,
    ];

    public function mount($item, $product, $inventory)
    {
        if ($item) {
            $this->form = $item->toArray();
        } else {
            $this->form['product_id'] = $product->id;
            $this->form['inventory_id'] = $inventory->id;
            $this->form['sku'] = $this->generateSKU($inventory->id);
            $this->form['barcode'] = $this->generateBarcode($inventory->id, $product->id);
            $this->form['purchase_price'] = 0.0;
            $this->form['sell_price'] = 0.0;
            $this->form['quantity'] = 0;
            $this->form['size'] = 'M';
            $this->form['color'] = 'white';
            $this->form['image'] = '';
        }
    }

    public function generateBarcode($inventoryId, $productId): string
    {
        return 'BC-' . str_pad($inventoryId, 5, '0', STR_PAD_LEFT) . '-' . str_pad($productId, 5, '0', STR_PAD_LEFT) . '-' . rand(100, 999);
    }

    public function generateSKU($inventoryId): string
    {
        return 'SKU-' . str_pad($inventoryId, 5, '0', STR_PAD_LEFT) . '-' . rand(100, 999);
    }

    public function saveItem(): void
    {
        $this->validate([
            'form.sku' => 'required',
            'form.barcode' => 'required',
            'form.purchase_price' => 'required',
            'form.sell_price' => 'required',
            'form.quantity' => 'required',
            'form.size' => 'required',
            'form.color' => 'required',
            'form.image' => 'required',
        ]);

        $this->form['image'] = $this->form['image']->store('public/inventory-items');
        $this->form['image'] = Storage::url($this->form['image']);

        InventoryItem::create($this->form);

        $this->redirect(route('admin.products.index'));
    }

    public function render(): View
    {
        return view('admin.Inventory.Item.form');
    }
}
