<?php

return array(

    /*
     |--------------------------------------------------------------------------
     | LaraMultiDbTenant Application's host
     |--------------------------------------------------------------------------
     |
     | This is your main application host
     |
     | If the application is the same as the database host, leave this as is or else
     | make sure to supply the private ip address of the application
     */

    'applicationHost' => '192.168.0.10',

    /*
     |--------------------------------------------------------------------------
     | LaraMultiDbTenant Database Prefix Settings
     |--------------------------------------------------------------------------
     |
     | All tenant's databases will be prefixed by this name as well as the
     | user name of the tenant database
     |
     | If you need more characters, please set this within your database server
     |
     */

    'prefix' => 'tod', //to signify the app. Try to make this 3-4 characters

    /*
     |--------------------------------------------------------------------------
     | LaraMultiDbTenant Tenant Model
     |--------------------------------------------------------------------------
     |
     | LaraMultiDbTenant Tenant Model is the Model you will be using for
     | the different organizations.
     | Change this to point to your Tenant/Organization model.
     |
     */
    'tenantmodel' => App\Tenant::class,

    /*
     |--------------------------------------------------------------------------
     | LaraMultiDbTenant Default Tenant Migration Database
     |--------------------------------------------------------------------------
     |
     | LaraMultiDbTenant Default Tenant Migration Database is the default database
     | needed for migrating/syncing your database for and across the tenant's database
     |
     */
    'default_app_database_name' => 'homestead',

    /*
     |--------------------------------------------------------------------------
     | LaraMultiDbTenant Tenant Database Connection
     |--------------------------------------------------------------------------
     |
     | LaraMultiDbTenant Tenant Database Connection is the connection you will be using for the different organizations.
     | Copy this to your laravel's database.connections's array
     | Don't forget to set the  in your .env file
     |
     */
    'tenant_database' => [
        'driver'    => 'mysql',
        'host'      => env('DB_TENANT_HOST', 'localhost'),
        'database'  => env('DB_TENANT_DATABASE', 'forge'),
        'username'  => env('DB_TENANT_USERNAME', 'forge'),
        'password'  => env('DB_TENANT_PASSWORD', ''),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
        'strict'    => false,
        'engine'    => null,
    ],

    'tenant_template' => [
        'driver'    => 'mysql',
        'host'      => env('DB_MIGRATOR_HOST', 'localhost'),
        'database'  => env('DB_MIGRATOR_DATABASE', 'forge'),
        'username'  => env('DB_MIGRATOR_USERNAME', 'forge'),
        'password'  => env('DB_MIGRATOR_PASSWORD', ''),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
        'strict'    => false,
        'engine'    => null,
    ]
);