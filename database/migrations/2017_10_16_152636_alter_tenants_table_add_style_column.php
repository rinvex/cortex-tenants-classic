<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTenantsTableAddStyleColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('rinvex.tenants.tables.tenants'), function (Blueprint $table) {
            $table->string('style')->after('group')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('rinvex.tenants.tables.tenants'), function (Blueprint $table) {
            $table->dropColumn('style');
        });
    }
}
