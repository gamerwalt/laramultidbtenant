<?php 

namespace gamerwalt\LaraMultiDbTenant\Contracts;

interface IDatabaseProvisioner
{
    /**
     * Provisions a database
     *
     * @param      $host
     * @param      $databaseName
     * @param      $username
     * @param      $password
     * @param null $appHost
     *
     * @return mixed
     */
    public function provisionDatabase($host, $databaseName, $username, $password, $appHost = null);

    /**
     * Syncs Database with new migrations created
     *
     * @param $host
     * @param $databaseName
     *
     * @return mixed
     */
    public function syncTenantDatabases($host, $databaseName);
} 