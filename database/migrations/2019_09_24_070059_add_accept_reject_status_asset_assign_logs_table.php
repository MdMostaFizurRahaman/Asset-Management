<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAcceptRejectStatusAssetAssignLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_assign_logs', function (Blueprint $table) {
            $table->boolean('accept_reject_status')->default('0')->after('assign_user');
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
            $table->dropColumn('accept_reject_status');
        });
    }
}
