<?php

namespace Core\Product;

use Core\Product\Providers\ProductService;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvder extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('product', function () {
            return new ProductService();
        });
        // register web and api routes
        $this->loadRoutesFrom(__DIR__ . '../Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '../Routes/api.php');

        // register views
        $this->loadViewsFrom(__DIR__ . '../Resources/Views', 'product');
    }
}
