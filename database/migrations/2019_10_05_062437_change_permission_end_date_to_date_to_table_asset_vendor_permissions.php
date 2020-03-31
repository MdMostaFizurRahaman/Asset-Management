<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePermissionEndDateToDateToTableAssetVendorPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_vendor_permissions', function (Blueprint $table) {
            $table->date('permission_end_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_vendor_permissions', function (Blueprint $table) {
            $table->dateTime('permission_end_date')->nullable()->change();
        });

    }
}
