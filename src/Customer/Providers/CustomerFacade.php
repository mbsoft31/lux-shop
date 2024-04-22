<?php

namespace Core\Customer\Providers;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin CustomerService
 */
class CustomerFacade extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'customer-service';
    }
}
