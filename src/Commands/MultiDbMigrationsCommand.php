<?php

namespace gamerwalt\LaraMultiDbTenant\Commands;

use gamerwalt\LaraMultiDbTenant\LaraMultiDbTenant;
use Illuminate\Console\Command;



class MultiDbFoldersCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tenant:folders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the template and tenant migration folders as well as the public folder for tenants';

    /**
     * @type \gamerwalt\LaraMultiDbTenant\LaraMultiDbTenant
     */
    private $multiDbTenant;

    /**
     * @type string
     */
    private $templateDirectoryName = 'template';

    /**
     * @type string
     */
    private $tenantsDirectoryName = 'tenant';

    /**
     * @type string
     */
    private $tenantPublicDirectory = 'tenants/documents';

    /**
     * Constructs the MultiDbMigrationsCommand
     *
     * @param \gamerwalt\LaraMultiDbTenant\LaraMultiDbTenant $multiDbTenant
     */
    public function __construct(LaraMultiDbTenant $multiDbTenant)
    {
        parent::__construct();

        $this->multiDbTenant = $multiDbTenant;
    }


    /**
     * Execute the console command
     *
     * @return void
     */
    public function handle()
    {
        $migrationsPath = $this->getMigrationPath();
        $publicPath = $this->getPublicPath();

        $templatePath = $migrationsPath . DIRECTORY_SEPARATOR . $this->templateDirectoryName;
        $tenantPath = $migrationsPath . DIRECTORY_SEPARATOR . $this->tenantsDirectoryName;
        $tenantPublicPath = $publicPath . DIRECTORY_SEPARATOR . $this->tenantPublicDirectory;

        if( !is_dir($templatePath)){
            $this->info("Creating the $templatePath for template migration tables");
            mkdir($templatePath, 0755, true);
            $this->info('Done.');
        }

        if( !is_dir($tenantPath)){
            $this->info("Creating the $tenantPath for tenant's migration tables");
            mkdir($tenantPath, 0755, true);
            $this->info('Done.');
        }

        if( !is_dir($tenantPublicPath)){
            $this->info("Creating the $tenantPublicPath for public documents");
            mkdir($tenantPublicPath, 0755, true);
            $this->info('Done.');
        }
    }

    private function getMigrationPath()
    {
        $path = app()->databasePath();
        return $path . DIRECTORY_SEPARATOR . 'migrations';
    }

    private function getPublicPath()
    {
        return app()->publicPath();
    }
} 