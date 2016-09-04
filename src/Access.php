<?php

namespace AM2Studio\LaravelAccess;

use Illuminate\Support\Facades\Facade;

class Access extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Access';
    }
}