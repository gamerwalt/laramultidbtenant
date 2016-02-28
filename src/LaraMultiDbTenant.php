<?php

namespace gamerwalt\LaraMultiDbTenant;

use Illuminate\Config\Repository;

class LaraMultiDbTenant
{
    /**
     * @type null
     */
    private $app;

    private $tenantModel;

    private $prefix;

    private $defaultDatabaseName;

    private $applicationHost;

    private $migrationConnection;

    protected $started = false;
    /**
     * @type \Illuminate\Config\Repository
     */
    private $config;
    private $tenantConnection;

    /**
     * @param \Illuminate\Config\Repository $config
     * @param null                          $app
     */
    public function __construct(Repository $config, $app = null)
    {
        $this->app = $app;
        $this->config = $config;
    }

    public function boot($tenantModel = null, $prefix = null)
    {
        if( !$tenantModel || !$prefix){
            return;
        }

        $this->tenantModel = $tenantModel;
        $this->prefix = $prefix;

        $this->pushConnections();
    }

    public function getLaravelApplication()
    {
        return $this->app;
    }

    public function getTenantModel()
    {
        if( !$this->tenantModel){
            $this->tenantModel = $this->config->get('tenantmodel');
        }

        return $this->tenantModel;
    }

    public function getDatabasePrefix()
    {
        if( !$this->prefix) {
            $this->prefix = $this->config->get('laramultidbtenant.prefix');
        }

        return $this->prefix;
    }

    public function getDefaultDatabaseName()
    {
        if( !$this->defaultDatabaseName) {
            $this->defaultDatabaseName = $this->config->get('laramultidbtenant.default_app_database_name');
        }

        return $this->defaultDatabaseName;
    }

    public function getApplicationHost()
    {
        if( !$this->applicationHost) {
            $this->applicationHost = $this->config->get('laramultidbtenant.applicationHost');
        }

        return $this->applicationHost;
    }

    public function getMigratorConnection()
    {
        if( !$this->migrationConnection) {
            $this->migrationConnection = $this->config->get('database.connections.tenant_template');
        }

        return $this->migrationConnection;
    }

    public function getTenantConnection()
    {
        if( !$this->tenantConnection) {
            $this->tenantConnection = $this->config->get('database.connections.tenant_database');
        }

        return $this->tenantConnection;
    }

    /**
     * Push the database connections to the laravel's database connections
     */
    private function pushConnections()
    {
        if($this->config->has('database.connections')) {
            //push our tenant_database and tenant_template configuration
            $this->config->set('database.connections.tenant_database', $this->config->get('laramultidbtenant.tenant_database'));
            $this->config->set('database.connections.tenant_template', $this->config->get('laramultidbtenant.tenant_template'));
        }
    }
} 