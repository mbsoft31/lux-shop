<?php

namespace Core\Sales;

use Core\Sales\Providers\SalesService;
use Illuminate\Support\ServiceProvider;

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
        // register web and api routes
        /*$this->loadRoutesFrom(__DIR__ . '../Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '../Routes/api.php');

        // register views
        $this->loadViewsFrom(__DIR__ . '../Resources/Views', 'sales');*/
    }
}
