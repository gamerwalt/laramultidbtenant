<?php 

namespace gamerwalt\LaraMultiDbTenant;

class LaraMultiDbTenant 
{
    /**
     * @type null
     */
    private $app;

    /**
     * Constructs LaraMultiDbTenant
     * @param null $app
     */
    public function __construct($app = null)
    {
        $this->app = $app;
    }
} 