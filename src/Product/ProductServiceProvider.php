<?php

namespace Core\Product;

use Core\Product\Livewire\InventoryItemForm;
use Core\Product\Livewire\ProductCreateForm;
use Core\Product\Livewire\ProductCreateFormStatic;
use Core\Product\Livewire\ProductMetaForm;
use Core\Product\Livewire\ProductVariants;
use Core\Product\Providers\ProductService;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('product-service', function () {
            return new ProductService();
        });

        Livewire::component(
            'inventory-item-form',
            InventoryItemForm::class
        );

        Livewire::component(
            'product-create-form',
            ProductCreateForm::class
        );

        Livewire::component(
            'product-create-form-static',
            ProductCreateFormStatic::class
        );

        Livewire::component(
            'product-meta-form',
            ProductMetaForm::class
        );

        Livewire::component(
            'product-variants-list',
            ProductVariants::class
        );

        // register web and api routes
        /*$this->loadRoutesFrom(__DIR__ . '../Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '../Routes/api.php');*/

        // register views
        /*$this->loadViewsFrom(__DIR__ . '../Resources/Views', 'product');*/
    }
}
