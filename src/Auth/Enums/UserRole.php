<?php

namespace Core\Auth\Enums;

enum UserRole: string
{
    case ADMINISTRATOR = 'administrator';
    case CASHIER = 'cashier';
    case INVENTORY_MANAGER = 'inventory_manager';
}
