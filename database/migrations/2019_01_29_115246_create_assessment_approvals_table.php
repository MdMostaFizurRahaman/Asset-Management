<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentApprovalsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('assessment_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('process_id')->default(0);
            $table->bigInteger('assessment_id')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('type')->default(0);
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
        Schema::dropIfExists('assessment_approvals');
    }

}
