<?php

namespace gamerwalt\LaraMultiDbTenant\Commands;

use App\TenantDatabase;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel;
use gamerwalt\LaraMultiDbTenant\Migrator;
use gamerwalt\LaraMultiDbTenant\LaraMultiDbTenant;

class ResyncMigrationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tenant:migrate-resync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resync the migration files. Add/update tables for all tenants';

    protected $migrator;

    /**
     * Constructs the MultiDbMigrationsCommand
     *
     * @param \gamerwalt\LaraMultiDbTenant\LaraMultiDbTenant $multiDbTenant
     */
    public function __construct(LaraMultiDbTenant $multiDbTenant, Kernel $kernel, Migrator $migrator)
    {
        parent::__construct();

        $this->multiDbTenant = $multiDbTenant;
        $this->kernel = $kernel;
        $this->migrator = $migrator;
    }

    /**
     * Execute the console command
     *
     * @return void
     */
    public function handle()
    {
        $migrationsPath = $this->getMigrationPath();
       
        $tenantsDatabases = TenantDatabase::all();

        foreach($tenantsDatabases as $tenantDatabase)
        {
            dd($tenantDatabase->tenant->company_name);

            $hostName = $tenantDatabase->hostname;
            $databaseName = $tenantDatabase->database_name;

            $this->info('Migrating database for ' . $tenantDatabase->tenant->company_name);
            $this->info('Database Name ' . $databaseName);
            $this->info('Host Name ' . $hostName);

            $this->migrator->UpdateTenantsMigration($hostName, $databaseName);

            $this->info('Done migrating database for ' . $tenantDatabase->tenant->company_name);
        }

        $this->info('Database Migration and Resync completed');
    }

    private function getMigrationPath()
    {
        $path = app()->databasePath();

        return $path . DIRECTORY_SEPARATOR . 'migrations';
    }
}