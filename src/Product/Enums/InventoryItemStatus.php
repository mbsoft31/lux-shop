<?php

namespace Core\Product\Enums;

enum InventoryItemStatus: string
{
    case InStock = 'in_stock';
    case OutOfStock = 'out_of_stock';
}
