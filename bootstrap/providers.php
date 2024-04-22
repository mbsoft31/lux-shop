<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\VoltServiceProvider::class,
    Core\Auth\AuthServiceProvider::class,
    Core\Product\ProductServiceProvider::class,
    Core\Customer\CustomerServiceProvider::class,
    Core\Sales\SalesServiceProvider::class,
];
