<?php

namespace Core\Sales;

use Core\Sales\Livewire\SaleCreateForm;
use Core\Sales\Providers\SalesService;
use Illuminate\Support\ServiceProvider;
use Livewire;

class SalesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('sales-service', function () {
            return new SalesService(
                productService: app('product-service'),
                customerService: app('customer-service')
            );
        });

        Livewire::component(
            'sale-create-form',
            SaleCreateForm::class
        );

    }
}
