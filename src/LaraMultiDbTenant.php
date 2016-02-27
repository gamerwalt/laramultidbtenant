<?php 

namespace gamerwalt\LaraMultiDbTenant;

class LaraMultiDbTenant 
{
    /**
     * @type null
     */
    private $app;

    protected $started = false;

    /**
     * Constructs LaraMultiDbTenant
     * @param null $app
     */
    public function __construct($app = null)
    {
        $this->app = $app;
    }

    public function start($tenantModel = null)
    {
        if( !$tenantModel){
            return;
        }
    }
} 