<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTenantsAddOwnerIdForeignIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('rinvex.tenantable.tables.tenants'), function (Blueprint $table) {
            $table->foreign('owner_id', 'tenants_owner_id_foreign')->references('id')->on(config('rinvex.fort.tables.users'))
                  ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('rinvex.tenantable.tables.tenants'), function (Blueprint $table) {
            $table->dropIndex('tenants_owner_id_foreign');
        });
    }
}
