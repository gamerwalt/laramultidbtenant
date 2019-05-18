<?php

namespace gamerwalt\LaraMultiDbTenant;

use DB;
use PDO;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Console\Kernel;
use Illuminate\Database\Events\StatementPrepared;

class Migrator 
{
    /**
     * @type \Illuminate\Contracts\Console\Kernel
     */
    private $kernel;

    /**
     * @type LaraMultiDbTenant
     */
    protected $multiDbTenant;

    /**
     * @type \Illuminate\Config\Repository
     */
    private $config;

    /**
     * Constructs the MysqlDatabaseProvisioner
     *
     * @param \Illuminate\Contracts\Console\Kernel $kernel
     */
    public function __construct(Kernel $kernel, Repository $config)
    {
        $this->kernel = $kernel;
        $this->config = $config;

        $this->multiDbTenant = app()->make('laramultitenantdb');
    }

    public function UpdateTenantsMigration($hostName, $databaseName)
    {
        $this->connectToHost($hostName, $databaseName);

        $this->migrateDatabase();

        $this->disconnectFromHost();
    }

    /**
     * Connects to the database host
     *
     * @param string $host
     */
    private function connectToHost($hostName, $databaseName)
    {
        if($this->config->has('database.connections')) {
            //push our tenant_database and tenant_template configuration
            $this->config->set('database.connections.tenant_database', $this->config->get('laramultidbtenant.tenant_database'));
            $this->config->set('database.connections.tenant_template', $this->config->get('laramultidbtenant.tenant_template'));
        }

        config(['database.connections.tenant_database.database' => $databaseName]);
        config(['database.connections.tenant_database.host' => $hostName]);

        DB::setDefaultConnection('tenant_database');

        Event::listen(StatementPrepared::class, function ($event) {
            $event->statement->setFetchMode(PDO::FETCH_OBJ);
        });

        DB::reconnect('tenant_database');
    }

    /**
     * Migrates the database
     */
    private function migrateDatabase()
    {
        $this->kernel->call('migrate', ['--path' => '/database/migrations/tenant', '--database' => 'tenant_database']);
    }

    /**
     * Disconnects from the host database
     */
    private function disconnectFromHost()
    {
        DB::disconnect('tenant_database');
    }
}