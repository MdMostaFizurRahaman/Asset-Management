<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowLogsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('workflow_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->default(0);
            $table->bigInteger('workflow_id')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('action_user_id')->default(0);
            $table->string('title');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('workflow_logs');
    }

}
