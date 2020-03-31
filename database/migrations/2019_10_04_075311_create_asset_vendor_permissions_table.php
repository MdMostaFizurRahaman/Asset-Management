<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetVendorPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_vendor_permissions', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('asset_id')->default(0);
            $table->bigInteger('vendor_id')->default(0);
            $table->timestamp('permission_end_date')->nullable();
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
        Schema::dropIfExists('asset_vendor_permissions');
    }
}
