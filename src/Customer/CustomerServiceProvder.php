<?php

namespace Core\Customer;

use Core\Product\Providers\CustomerService;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvder extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('customer', function () {
            return new CustomerService();
        });
        // register web and api routes
        $this->loadRoutesFrom(__DIR__ . '../Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '../Routes/api.php');

        // register views
        $this->loadViewsFrom(__DIR__ . '../Resources/Views', 'product');
    }
}
