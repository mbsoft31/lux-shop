<?php

namespace Core\Product\Livewire;

use Core\Product\Models\ProductData;
use Core\Product\Providers\ProductFacade;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductCreateForm extends Component
{
    use WithFileUploads;

    public bool $show = false;
    public string $label = 'Create';
    public array $form = [
        'name' => null,
        'description' => null,
        'purchase_price' => 0,
        'sell_price' => 0,
        'quantity' => 0,
        'image' => null,
        'meta' => [],
    ];

    public array $metaConfig;

    public function mount(): void
    {
        $this->metaConfig = ProductData::metaConfig();
    }

    public function updateMetaSizeType(): void
    {
        if($this->form['meta']['type'] == 'footwear')
        {
            $this->form['meta']['size_type'] = 'numeric';
        }else {
            $this->form['meta']['size_type'] = 'char';
        }
    }

    public function saveProduct(): void
    {
        $this->validateForm();
        $product = $this->createProduct();
        // $this->updateProductImage($product);
        $this->resetForm();

        $this->redirect(route('admin.product.edit', $product->id));
    }

    private function validateForm(): void
    {
        $this->validate([
            'form.name' => 'required|string',
            'form.description' => 'nullable|string',
            'form.image' => 'nullable|image|max:1024',
        ]);
    }

    private function createProduct()
    {
        return ProductFacade::create($this->form);
    }

    private function updateProductImage(ProductData $product): bool
    {
        if ($product->image != $this->form['image'])
        {
            $path = $this->form['image']->store('public/products/'. $product->id);
            $path = Storage::url($path);
            $product->image = $path;
            return $product->toModel()->save();
        }else {
            return false;
        }
    }

    private function resetForm(): void
    {
        $this->reset('form');
        $this->show = false;
        session()->flash('success', 'Product created successfully');
    }

    public function render(): View
    {
        return view('admin.product.partials.product-form', [
            'metaConfig' => ProductData::metaConfig(),
        ]);
    }
}
