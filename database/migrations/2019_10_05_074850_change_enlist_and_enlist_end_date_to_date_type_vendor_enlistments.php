<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEnlistAndEnlistEndDateToDateTypeVendorEnlistments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_enlistments', function (Blueprint $table) {
            $table->date('enlist_date')->nullable()->change();
            $table->date('enlist_end_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_enlistments', function (Blueprint $table) {
            $table->dateTime('enlist_date')->nullable()->change();
            $table->dateTime('enlist_end_date')->nullable()->change();

        });

    }
}
