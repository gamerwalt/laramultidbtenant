<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_databases', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('tenant_database_id');
            $table->integer('tenant_id')->unsigned();
            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('cascade');
            $table->string('driver');
            $table->integer('port');
            $table->string('hostname');
            $table->string('database_name');
            $table->string('user_name');
            $table->string('password');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tenant_databases');
    }
}
