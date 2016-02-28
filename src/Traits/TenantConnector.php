<?php
namespace gamerwalt\LaraMultiDbTenant\Traits;

use gamerwalt\LaraMultiDbTenant\Contracts\ITenantDatabase;
use gamerwalt\LaraMultiDbTenant\TenantDatabaseException;

trait TenantConnector
{
    protected $config;

    public function resolveDatabase(ITenantDatabase $tenantDatabaseModel)
    {
        if( !$tenantDatabaseModel->getDatabaseNameIdentifier()
            || !$tenantDatabaseModel->getHostNameIdentifier()
            || !$tenantDatabaseModel->getUserNameIdentifier()
            || !$tenantDatabaseModel->getPasswordIdentifier()
            || !$tenantDatabaseModel->getTenant()) {

            throw new TenantDatabaseException("Please supply the necessary identifiers to resolve your tenant database", null, null);
        }

        $config = app('config');
        $config->set('database.connections.tenant_database.host', $tenantDatabaseModel->getHostNameIdentifier());
        $config->set('database.connections.tenant_database.database', $tenantDatabaseModel->getDatabaseNameIdentifier());
        $config->set('database.connections.tenant_database.username', $tenantDatabaseModel->getUserNameIdentifier());
        $config->set('database.connections.tenant_database.password', $tenantDatabaseModel->getPasswordIdentifier());
        $config->set('database.connections.tenant_database.driver', $tenantDatabaseModel->getDriverIdentifier());

        app('db')->setDefaultConnection('tenant_database');

        $companyNameIdentifier = $tenantDatabaseModel->getCompanyNameIdentifier();

        session()->put('company_name' , $tenantDatabaseModel->getTenant()->$companyNameIdentifier);
    }
}