<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('category_id')->default(0);
            $table->bigInteger('sub_category_id')->default(0);
            $table->bigInteger('brand_id')->default(0);
            $table->bigInteger('company_id')->default(0);
            $table->bigInteger('division_id')->default(0);
            $table->bigInteger('department_id')->default(0);
            $table->bigInteger('unit_id')->default(0);
            $table->bigInteger('office_location_id')->default(0);
            $table->integer('status')->default(0);
            $table->tinyInteger('archive')->default(0);
            $table->string('model')->nullable();
            $table->text('specification')->nullable();
            $table->string('supplier')->nullable();
            $table->string('vendor')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('installation_date')->nullable();
            $table->integer('guarantee')->default(0);
            $table->string('image')->nullable();
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
        Schema::dropIfExists('assets');
    }

}
