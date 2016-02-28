<?php

namespace gamerwalt\LaraMultiDbTenant\Traits;

trait MigrateTenantDatabase
{
    public function migrateTenantDatabase($host, $databaseName, $username, $password)
    {
        $migrator = app()->make('tenantdatabaseprovisioner');

        $migrator->provisionDatabase($host, $databaseName, $username, $password);
    }

    public function syncTenantDatabase($host, $databaseName)
    {
        $migrator = app()->make('tenantdatabaseprovisioner');

        $migrator->syncTenantDatabase($host, $databaseName);
    }
} 