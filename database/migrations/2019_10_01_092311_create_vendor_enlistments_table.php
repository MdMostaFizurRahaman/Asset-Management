<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorEnlistmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_enlistments', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('client_id')->default(0);
            $table->bigInteger('company_id')->default(0);
            $table->bigInteger('vendor_id')->default(0);
            $table->timestamp('enlist_date')->nullable();
            $table->timestamp('enlist_end_date')->nullable();
            $table->text('note')->nullable();
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
    public function down()
    {
        Schema::dropIfExists('vendor_enlistments');
    }
}
