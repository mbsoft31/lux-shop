<?php

namespace Core\Product\Livewire;

use App\Models\Product;
use Illuminate\View\View;
use Livewire\Component;

class ProductVariants extends Component
{

    public Product $product;

    public function mount($product): void
    {
        $this->product = $product;
    }

    public function render(): View
    {
        $inventory = $this->product->inventory;
        return view('admin.product.partials.product-variants-list', [
            'inventory' => $inventory,
            'items' => $inventory->items,
        ]);
    }

}
