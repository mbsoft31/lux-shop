<?php

namespace Core\Auth\Providers;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin AuthService
 */
class AuthFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'auth-service';
    }
}
