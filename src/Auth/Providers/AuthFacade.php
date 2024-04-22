<?php

namespace Core\Auth\Providers;

use Illuminate\Support\Facades\Facade;

/**
 * @method static seedRoles()
 */
class AuthFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'auth-service';
    }
}
