[![Build Status](https://travis-ci.org/gamerwalt/laramultidbtenant.svg?branch=master)](https://travis-ci.org/gamerwalt/laramultidbtenant)
# Multi-Database Tenant Package for Laravel #
This package is meant for Laravel applications to help with Multi-Database Tenant Applications.

A sample laravel application that uses this package can be found at [github](https://github.com/gamerwalt/TodoMultitenantDemo)

# Installation #

```
composer require gamerwalt/laramultidbtenant
```
Add the service providers to your application providers array in config/app.php
A Facade is also available and can be added...

### Providers ###
```
gamerwalt\LaraMultiDbTenant\LaraMultiDbTenantServiceProvider::class
```

### Facade ###
```
LaraMultiDbTenant' => gamerwalt\LaraMultiDbTenant\Facade::class
```

### Configuration Files ###
```
php artisan vendor:publish
```
This will copy the laramultidbtenant.php configuration file into the app/config directory as well as copy the tenant, tenant_users and tenant_databases migration files needed. Create your models.

Setup the database for your Tenants in your .env files

### Create the needed model classes ###

This will create the Tenant, TenantDatabase, TenantUser models. Make sure to provide the right relationships and don't forget to create the relationships within the [User, Tenant, TenantUser and TenantDatabase models](https://github.com/gamerwalt/TodoMultitenantDemo/tree/master/app) as well as set the connection properties.
```
php artisan tenant:basemodels
```
```
class Tenant extends Model
{
    protected $connection = 'todo';

    protected $table = 'tenants';

    protected $primaryKey = 'tenant_id';

    protected $fillable = ['tenant_uid', 'company_name', 'short_company_name', 'database_prefix', 'address'];
    .......
```

### Create the template, tenant migration folders as well as a tenant public folder ###
```
php artisan tenant:folders
```

This package registers a middleware called authTenant within it's service provider.
This is needed in order to automatically set the default connections for the Application's model

### For a todo application [see demo application](https://github.com/gamerwalt/TodoMultitenantDemo) ###
Inside your controllers that will control tenant specific routing, add the following to the __construct methods
```
$this->middleware('auth');
$this->middleware('authTenant'); //This is automatically pushed to laravel's kernel
```
also make sure to include the trait to do migrations automatically once the tenant has registered their company...
```
use MigrateTenantDatabase;
```
Complete namespace for this is...
```
use gamerwalt\LaraMultiDbTenant\Traits\MigrateTenantDatabase;
```
### Create your migration files ###
This assumes you have already done...
```
php artisan vendor:publish
```
So create your migration files...
```
php artisan make:migration create_todo_table --create=todos --path=database/migrations/tenant
```
#### Your TenantDatabase Model ###
**This is important**

Your TenantDatabase model **must** implement the ITenantDatabase interface
```
class TenantDatabase extends Model implements ITenantDatabase
```
Once that's done, start with registering a user, at least collect information needed. In your controller that registers the user, tenant, tenant_database, tenant_users you should be able to do...
```
$this->migrateTenantDatabase($tenantDatabase->hostname, $tenantDatabase->database_name, $tenantDatabase->user_name, $tenantDatabase->password);
```
Use [this](https://github.com/gamerwalt/TodoMultitenantDemo) demo as a guide.
See SessionsController@postRegister.
This should show the code...
```
    $input = $request->all();
    $email = $input['email'];
    $password = $input['password'];
    $name = $input['name'];
    $companyName = $input['company_name'];

    DB::beginTransaction();

    $user = $this->registerUser($email, $password, $name);
    $tenant = $this->registerTenant($companyName);
    $tenantUser = $this->createTenantUserDetails($user, $tenant);
    $tenantDatabase = $this->createTenantDatabase($tenant);

    DB::commit();
    //now we can migrate the database of the tenant using the tenant database settings

    $this->migrateTenantDatabase($tenantDatabase->hostname, $tenantDatabase->database_name,
                                     $tenantDatabase->user_name, $tenantDatabase->password);
```

# Questions #
Twitter: [@gamerwalt](https://twitter.com/gamerwalt)

# Future #
1. Do some clean up of the code.
1. Command for creating template and tenant migration files
1. Command to migrate to template database
1. Command to sync new migration files
1. Command to copy any needed data from template database to all tenant databases
1. Add tests