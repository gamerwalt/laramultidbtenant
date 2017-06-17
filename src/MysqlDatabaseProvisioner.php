<?php 

namespace gamerwalt\LaraMultiDbTenant;

use DB;
use gamerwalt\LaraMultiDbTenant\Contracts\IDatabaseProvisioner;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Events\StatementPrepared;
use Illuminate\Support\Facades\Event;
use PDO;

class MysqlDatabaseProvisioner implements IDatabaseProvisioner
{
    /**
     * @type \Illuminate\Contracts\Console\Kernel
     */
    private $kernel;

    /**
     * @type LaraMultiDbTenant
     */
    protected $multiDbTenant;

    /**
     * Constructs the MysqlDatabaseProvisioner
     *
     * @param \Illuminate\Contracts\Console\Kernel $kernel
     */
    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
        $this->multiDbTenant = app()->make('laramultitenantdb');
    }

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
    public function provisionDatabase($host, $databaseName, $username, $password, $appHost = null)
    {
        if( !$appHost) {
            $appHost = $this->multiDbTenant->getApplicationHost();
        }

        $this->connectToHost($host);
        $this->createDatabase($databaseName);
        $this->createUser($appHost, $databaseName, $username, $password);
        $this->migrateDatabase($databaseName, $host);
        $this->disconnectFromHost();
    }

    /**
     * Syncs Database with new migrations created
     *
     * @param $host
     * @param $databaseName
     *
     * @return mixed
     */
    public function syncTenantDatabases($host, $databaseName)
    {
        $this->connectToHost($host, $databaseName);

        $this->migrateDatabase();

        $this->disconnectFromHost();
    }

    /**
     * Connects to the database host
     *
     * @param string $host
     */
    private function connectToHost($host)
    {
        config(['database.connections.tenant_database.database' => $this->multiDbTenant->getDefaultDatabaseName()]);
        config(['database.connections.tenant_database.host' => $host]);

        DB::setDefaultConnection('tenant_database');
        Event::listen(StatementPrepared::class, function ($event) {
            $event->statement->setFetchMode(PDO::FETCH_OBJ);
        });
        DB::reconnect('tenant_database');
    }

    /**
     * Creates a database with the current connection
     *
     * @param string $databaseName
     */
    private function createDatabase($databaseName)
    {
        $charSet = config('database.connections.tenant_database.charset');
        $collation = config('database.connections.tenant_database.collation');

        $query = "CREATE SCHEMA $databaseName CHARACTER SET $charSet COLLATE $collation" ;

        $this->execute($query);

        //once the statement has been executed
        //we can now successfully connect to the database
        config(['database.connections.tenant_database.database' => $databaseName]);
        DB::setDefaultConnection('tenant_database');
        Event::listen(StatementPrepared::class, function ($event) {
            $event->statement->setFetchMode(PDO::FETCH_OBJ);
        });
        DB::reconnect('tenant_database');
    }

    /**
     * Executes the passed statement
     *
     * @param string $query
     */
    private function execute($query)
    {
        DB::statement($query);
    }

    /**
     * Creates a user for the specific database
     *
     * @param $appHost
     * @param $databaseName
     * @param $username
     * @param $password
     */
    private function createUser($appHost, $databaseName, $username, $password)
    {
        $createUserQuery = "CREATE USER '$username'@'$appHost' IDENTIFIED BY '$password'";

        $this->execute($createUserQuery);

        $grantUserQuery = "GRANT SELECT, INSERT, UPDATE, EXECUTE, DELETE ON $databaseName.* TO '$username'@'$appHost' IDENTIFIED BY '$password'";

        $this->execute($grantUserQuery);
    }

    /**
     * Migrates the database
     */
    private function migrateDatabase()
    {
        $this->kernel->call('migrate', ['--path' => '/database/migrations/tenant', '--database' => 'tenant_database']);
    }

    /**
     * Disconnects from the host database
     */
    private function disconnectFromHost()
    {
        DB::disconnect('tenant_database');
    }
}
