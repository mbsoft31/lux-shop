<?php

namespace Core\Product\Livewire;

use App\Models\Product;
use Core\Product\Models\ProductData;
use Core\Product\Traits\DataHasMeta;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductMetaForm extends Component
{
    use WithFileUploads;

    public array $metaConfig;

    public Product $product;
    public array $meta = [];
    public string $metaKey = 'meta';

    public function mount($product = null): void
    {
        $this->meta = $product->meta;
        $this->metaConfig();
    }

    public function updateMetaSizeType(): void
    {
        if($this->meta['type'] == 'footwear')
        {
            $this->meta['size_type'] = 'numeric';
        }else {
            $this->meta['size_type'] = 'char';
        }
    }

    public function saveMeta(): void
    {
        try {
            $product = $this->product;
            $product->meta = $this->meta;
            $this->validate($this->MetaFieldRules());
            $product->save();
            session()->flash('success', 'Product metadata saved successfully');
        } catch (ValidationException $e) {
            session()->flash('error', 'Failed to save product meta');
        }
    }

    public function render(): View
    {
        return view('admin.product.partials.product-meta-form');
    }

    public function MetaFieldRules(): array
    {
        $rules = [];
        foreach ($this->metaConfig() as $field => $fieldConfig) {
            $validation = [];

            $validation[] = $fieldConfig['required'] ? 'required' : 'nullable';
            $validation[] = match ($fieldConfig['type']) {
                'checkbox' => 'boolean',
                'number' => 'numeric',
                'select' => 'in:' . implode(',', array_keys($fieldConfig['options'])),
                default => 'string',
            };

            $key = $this->metaKey . '.' . $field;
            $rules[$key] = $validation;
        }
        return $rules;
    }

    public function metaConfig(): array
    {
        return $this->metaConfig = [
            'type' => [
                'label' => __('Type'),
                'type' => 'select',
                'options' => [
                    'clothing' => __('Clothing'),
                    'footwear' => __('Footwear'),
                    'underwear' => __('Underwear'),
                    'outerwear' => __('Outerwear'),
                ],
                'required' => true,
                'default' => 'clothing',
            ],
            'size_type' => [
                'type' => 'select',
                'label' => __('Size Type'),
                'options' => [
                    'char' => 'Character',
                    'numeric' => 'Numeric',
                ],
                'required' => true,
                'default' => 'char',
            ],
            'size' => [
                'type' => 'select',
                'label' => __('Size'),
                'options' => [],
                'required' => false,
            ],
            'brand' => [
                'type' => 'text',
                'label' => __('Brand'),
                'required' => false,
            ],
            'material' => [
                'type' => 'text',
                'label' => __('Material'),
                'required' => false,
            ],
            'style' => [
                'type' => 'text',
                'label' => __('Style'),
                'required' => false,
            ],
            'is_best_seller' => [
                'type' => 'checkbox',
                'label' => __('Best Seller'),
                'required' => false,
            ],
            'is_new' => [
                'type' => 'checkbox',
                'label' => __('New'),
                'required' => false,
                'default' => true,
            ],
            'is_featured' => [
                'type' => 'checkbox',
                'label' => __('Featured'),
                'required' => false,
            ],
        ];
    }
}
