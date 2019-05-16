<?php

namespace gamerwalt\LaraMultiDbTenant;

class LaraMultiTenantDB extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'laramultitenantdb';
    }
} 