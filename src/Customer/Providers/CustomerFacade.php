<?php

namespace Core\Customer\Providers;

use Illuminate\Support\Facades\Facade;

/**
 * @method static create(mixed $customerData)
 */
class CustomerFacade extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'customer-service';
    }
}
