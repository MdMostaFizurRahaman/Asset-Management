<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetAssignLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_assign_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->default('0');
            $table->bigInteger('asset_id')->default('0');
            $table->bigInteger('assign_user')->default('0');
            $table->boolean('is_return')->default('0');
            $table->timestamp('returned_at')->nullable();
            $table->text('note')->nullable();
            $table->text('return_note')->nullable();
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
        Schema::dropIfExists('asset_assign_logs');
    }
}
