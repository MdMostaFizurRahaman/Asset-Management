<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTwoColumnFromAssetAssignLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_assign_logs', function (Blueprint $table) {
            $table->dropColumn('returned_at');
            $table->dropColumn('return_note');
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
            $table->timestamp('returned_at')->nullable();
            $table->text('return_note')->nullable();
        });
    }
}
