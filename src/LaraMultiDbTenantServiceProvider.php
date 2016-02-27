<?php

namespace gamerwalt\LaraMultiDbTenant;

use Illuminate\Support\ServiceProvider;

class LaraMultiDbTenantServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/laramultidbtenant.php';
        $this->mergeConfigFrom($configPath, 'laramultidbtenant');

        $this->app->singleton('LaraMultiDbTenant', function($app) {
            $laraMultiDbTenant = new LaraMultiDbTenant($app);

            return $laraMultiDbTenant;
        });

        $this->app->alias('LaraMultiDbTenant', 'gamerwalt\LaraMultiDbTenant\LaraMultiDbTenant');

        $this->app['command.laramultidbtenant.migrations'] = $this->app->share(
        function($app) {
            return new Commands\MultiDbMigrationsCommand($app['LaraMultiDbTenant']);
        }
        );

        $this->commands(array('command.laramultidbtenant.migrations'));
    }

    /**
     * Bootstrap the application events
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/laramultidbtenant.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');

        $enabled = $this->app['config']->get('laramultidbtenant.enabled');
        $tenantModel = $this->app['config']->get('laramultidbtenant.TenantModel');

        if ( ! $enabled) {
            return;
        }

        $laraMultidbTenant = $this->app['LaraMultiDbTenant'];
        $laraMultidbTenant->start($tenantModel);
    }

    /**
     * Returns the config path for
     */
    private function getConfigPath()
    {
        return config_path('laramultidbtenant.php');
    }
}