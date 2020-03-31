<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoveOrderColumnAssetAssignLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_assign_logs', function (Blueprint $table) {
            $table->tinyInteger('store_from')->nullable()->after('note');
            $table->tinyInteger('store_to')->nullable()->after('store_from');
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
            $table->dropColumn('store_from');
            $table->dropColumn('store_to');
        });
    }
}
