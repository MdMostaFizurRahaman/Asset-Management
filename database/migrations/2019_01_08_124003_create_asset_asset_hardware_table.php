<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetAssetHardwareTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('asset_asset_hardware', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asset_id')->default(0);
            $table->bigInteger('asset_hardware_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('asset_asset_hardware');
    }

}
