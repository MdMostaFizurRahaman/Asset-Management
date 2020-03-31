<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorEnlistmentAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_enlistment_attachments', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('vendor_enlistment_id')->default(0);
            $table->string('title');
            $table->string('filename')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('vendor_enlistment_attachments');
    }
}
