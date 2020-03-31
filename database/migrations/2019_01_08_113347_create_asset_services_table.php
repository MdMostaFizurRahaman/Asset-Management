<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetServicesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('asset_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('admin_id')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('client_id')->default(0);
            $table->string('title');
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('asset_services');
    }

}
