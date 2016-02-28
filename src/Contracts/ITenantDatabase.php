<?php

namespace gamerwalt\LaraMultiDbTenant\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ITenantDatabase
{
    /**
     * Return the field that identifies the hostname of the Tenant
     *
     * @return string
     */
    public function getHostNameIdentifier();

    /**
     * Return the field that identifies the database name of the Tenant
     *
     * @return string
     */
    public function getDatabaseNameIdentifier();

    /**
     * Return the field that identifies the username of the Tenant database
     *
     * @return string
     */
    public function getUserNameIdentifier();

    /**
     * Return the field that identifies the password of the Tenant database
     *
     * @return string
     */
    public function getPasswordIdentifier();

    /**
     * Return the field that identifies the driver of the Tenant database
     *
     * @return string
     */
    public function getDriverIdentifier();

    /**
     * Return the field that identifies the port of the Tenant database
     *
     * @return string
     */
    public function getPortIdentifier();

    /**
     * Return the Model of the Tenant
     * @return Model
     */
    public function getTenant();

    /**
     * Return the field that identifies the company name of the Tenant model
     *
     * @return string
     */
    public function getCompanyNameIdentifier();
} 