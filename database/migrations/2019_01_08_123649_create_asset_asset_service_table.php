<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetAssetServiceTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('asset_asset_service', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asset_id')->default(0);
            $table->bigInteger('asset_service_id')->default(0);
        });

        Schema::table('asset_asset_tag', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('asset_asset_service');
    }

}
