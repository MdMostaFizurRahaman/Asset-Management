<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('processes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('workflow_id')->default(0);
            $table->string('title');
            $table->tinyInteger('type')->default(0);
            $table->integer('minimum_no')->default(0);
            $table->tinyInteger('process_type')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->integer('order')->default(0);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('processes');
    }

}
