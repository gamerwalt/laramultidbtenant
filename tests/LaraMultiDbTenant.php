<?php 

use gamerwalt\LaraMultiDbTenant\LaraMultiDbTenant;

class LaraMultiDbTenantTest extends PHPUnit_Framework_TestCase
{

    /** @test */
    public function it_can_load_the_application_container()
    {
        $app = null;
        $laraMultiDbTenant = new LaraMultiDbTenant($app);

        $this->assertEquals('Application', $laraMultiDbTenant->app);
    }
} 