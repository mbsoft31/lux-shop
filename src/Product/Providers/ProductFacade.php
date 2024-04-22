<?php

namespace Core\Product\Providers;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin ProductService
 */
class ProductFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'product-service';
    }
}
