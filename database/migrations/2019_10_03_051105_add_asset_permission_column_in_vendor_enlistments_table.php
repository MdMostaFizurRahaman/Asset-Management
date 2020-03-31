<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssetPermissionColumnInVendorEnlistmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_enlistments', function (Blueprint $table) {
            $table->tinyInteger('asset_permission')->default('0')->after('vendor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_enlistments', function (Blueprint $table) {
            $table->dropColumn('asset_permission');
        });
    }
}
