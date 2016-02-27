<?php

namespace gamerwalt\LaraMultiDbTenant;

class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'LaraMultiDbTenant';
    }
} 