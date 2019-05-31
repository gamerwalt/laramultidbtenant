<?php

namespace gamerwalt\LaraMultiDbTenant;

use App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use gamerwalt\LaraMultiDbTenant\Commands\BaseModelsCommand;
use gamerwalt\LaraMultiDbTenant\Commands\MultiDbFoldersCommand;
use gamerwalt\LaraMultiDbTenant\Commands\ResyncMigrationCommand;

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
        $this->mergeConfig();
        $this->setup();
        $this->registerCommands();
        $this->registerSingletons();
    }

    /**
     * Bootstrap the application events
     *
     * @param \Illuminate\Contracts\Http\Kernel $kernel
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        $app = $this->app;

        $configPath = __DIR__ . '/../config/laramultidbtenant.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');

        $migrationsPath = __DIR__ . '/../migrations/';
        $this->publishes([$migrationsPath => $this->getMigrationsPath()], 'migrations');

        $prefix = $this->app['config']->get('laramultidbtenant.prefix');
        $tenantModel = $this->app['config']->get('laramultidbtenant.tenantmodel');

        if($app->runningInConsole()) {
            return;
        }

        $this->app['router']->middleware('authTenant', 'gamerwalt\LaraMultiDbTenant\AuthTenant');

        $laraMultidbTenant = $this->app['laramultitenantdb'];
        $laraMultidbTenant->boot($tenantModel, $prefix);
    }


    /**
     * Setup
     *
     *
     * @return void
     */
    protected function setup()
    {
        $this->app->singleton('LaraMultiDbTenant', function($app) {
            $laraMultiDbTenant = new LaraMultiDbTenant($app['config'],$app);

            return $laraMultiDbTenant;
        });

        $this->app->alias('laramultitenantdb', 'gamerwalt\LaraMultiDbTenant\LaraMultiDbTenant');
    }

    /**
     * Register Singletons
     *
     *
     * @return void
     */
    protected function registerSingletons()
    {
        App::singleton('laramultitenantdb', function($app){
            return new LaraMultiDbTenant($app['config'],$app);
        });

        App::singleton('tenantdatabaseprovisioner', function(){
            return new MysqlDatabaseProvisioner($this->app->make('Illuminate\Contracts\Console\Kernel'));
        });

        App::singleton('authTenant', function(){
            return new AuthTenant();
        });
    }

    /**
     * Register commands needed
     *
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->app->singleton('command.tenant.migrations', function($app) {
            return new MultiDbFoldersCommand($app['laramultitenantdb']);
        });

        $this->app->singleton('command.tenant.basemodels', function($app) {
            return new BaseModelsCommand($app['laramultitenantdb'], $this->app->make('Illuminate\Contracts\Console\Kernel'));
        });

        $this->app->singleton('command.tenant.migrate-resync', function($app) {
            return new ResyncMigrationCommand($app['laramultitenantdb'], $this->app->make('Illuminate\Contracts\Console\Kernel'), $this->app->make('gamerwalt\LaraMultiDbTenant\Migrator'));
        });

        $this->commands(array('command.tenant.migrations'));
        $this->commands(array('command.tenant.basemodels'));
        $this->commands(array('command.tenant.migrate-resync'));
    }

    /**
     * Merge configuration
     *
     *
     * @return void
     */
    protected function mergeConfig()
    {
        $configPath = __DIR__ . '/../config/laramultidbtenant.php';
        $this->mergeConfigFrom($configPath, 'laramultidbtenant');
    }

    /**
     * Get the active router.
     *
     * @return Router
     */
    protected function getRouter()
    {
        return $this->app['router'];
    }

    /**
     * Returns the config path for
     */
    private function getConfigPath()
    {
        return config_path('laramultidbtenant.php');
    }

    /**
     * Returns the migrations path for
     */
    private function getMigrationsPath()
    {
        return database_path('migrations');
    }
}