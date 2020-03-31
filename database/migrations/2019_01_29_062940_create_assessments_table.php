<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('assessments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asset_id')->default(0);
            $table->bigInteger('vendor_id')->default(0);
            $table->bigInteger('workflow_id')->default(0);
            $table->integer('total_steps')->default(0);
            $table->integer('current_steps')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('deleted')->default(0);
            $table->integer('required_days')->default(0);
            $table->date('submit_date')->nullable();
            $table->double('cost', 16, 2)->default(0);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('assessments');
    }

}
