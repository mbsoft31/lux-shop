<?php

namespace Core\Product\Livewire;

use Core\Product\Providers\ProductFacade;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductCreateForm extends Component
{

    use WithFileUploads;

    public bool $show = false;
    public array $form = [
        'name' => null,
        'description' => null,
        'image' => null,
    ];

    public function saveProduct(): void
    {
        $this->validate([
            'form.name' => 'required|string',
            'form.description' => 'nullable|string',
            'form.image' => 'nullable|image|max:1024',
        ]);

        $product = ProductFacade::create($this->form);

        $this->form['image'] = $this->form['image']->store('public/products/'. $product->id);
        $this->form['image'] = Storage::url($this->form['image']);

        $product->image = $this->form['image'];
        $product->toModel()->save();

        $this->reset('form');

        $this->show = false;
    }

    public function render(): View
    {
        return view('admin.product.partials.product-form');
    }

}
