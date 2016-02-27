<?php 

namespace gamerwalt\LaraMultiDbTenant;

use Illuminate\Support\ServiceProvider;

class LaraMultiDbTenantServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('LaraMultiDbTenant', function($app){
            $laraMultiDbTenant = new LaraMultiDbTenant($app);

        });
    }

    /**
     * Bootstrap the application events
     *
     * @return void
     */
    public function boot()
    {

    }
}