<?php

namespace Core\Sales\Providers;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin SalesService
 */
class SalesFacade extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'sales-service';
    }
}
