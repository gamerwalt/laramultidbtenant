<?php 

namespace gamerwalt\LaraMultiDbTenant\Commands;

use gamerwalt\LaraMultiDbTenant\LaraMultiDbTenant;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel;

class BaseModelsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tenant:basemodels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the tenant, tenant_user, tenant_database models';

    /**
     * @type \gamerwalt\LaraMultiDbTenant\LaraMultiDbTenant
     */
    private $multiDbTenant;
    /**
     * @type \Illuminate\Contracts\Console\Kernel
     */
    private $kernel;

    /**
     * Constructs the BaseModelsCommand
     *
     * @param \gamerwalt\LaraMultiDbTenant\LaraMultiDbTenant $multiDbTenant
     * @param \Illuminate\Contracts\Console\Kernel           $kernel
     */
    public function __construct(LaraMultiDbTenant $multiDbTenant, Kernel $kernel)
    {
        parent::__construct();

        $this->multiDbTenant = $multiDbTenant;
        $this->kernel = $kernel;
    }

    /**
     * Execute the console command
     *
     * @return void
     */
    public function handle()
    {
        $this->kernel->call('make:model', ['name' => 'Tenant']);
        $this->kernel->call('make:model', ['name' => 'TenantUser']);
        $this->kernel->call('make:model', ['name' => 'TenantDatabase']);

        $this->info('Tenant, TenantUser, TenantDatabase models created successfully.');
        $this->info('Remember to set the relationships between Tenant, TenantUser, TenantDatabase as well as the default user model!');
    }
} 