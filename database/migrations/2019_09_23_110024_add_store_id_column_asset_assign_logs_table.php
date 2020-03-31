<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStoreIdColumnAssetAssignLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_assign_logs', function (Blueprint $table) {
            $table->bigInteger('store_id')->nullable()->after('is_return');
            $table->bigInteger('return_store_id')->nullable()->after('store_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_assign_logs', function (Blueprint $table) {
            $table->dropColumn('store_id');
            $table->dropColumn('return_store_id');
        });
    }
}
