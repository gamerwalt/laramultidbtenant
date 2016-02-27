<?php

namespace gamerwalt\LaraMultiDbTenant\Commands;

use gamerwalt\LaraMultiDbTenant\LaraMultiDbTenant;
use Illuminate\Console\Command;



class MultiDbMigrationsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramultidbtenant:migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the template and tenant migration folders';

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
    private $tenantPublicDirectory = 'tenants';

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
            $this->info('Creating... ' . $templatePath);
            mkdir($templatePath, 0755, true);
            $this->info('Done.');
        }

        if( !is_dir($tenantPath)){
            $this->info('We need to create the ' . $tenantPath);
            mkdir($tenantPath, 0755, true);
            $this->info('Done.');
        }

        if( !is_dir($tenantPublicPath)){
            $this->info('We need to create the ' . $tenantPublicPath);
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