<?php

namespace Core\Product\Providers;

use Illuminate\Support\Facades\Facade;

/**
 * @method static create(array $data)
 * @method static createInventory($id, array $data)
 * @method static createInventoryItem($id, array $variantData)
 */
class ProductFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'product-service';
    }
}
