<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSixColumnsForDepressionsTaskAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->double('purchase_value', 12, 2)->nullable()->after('vendor');
            $table->tinyInteger('is_depreciation')->default('0')->after('purchase_value');
            $table->tinyInteger('depreciation_type')->nullable()->after('is_depreciation');
            $table->tinyInteger('depreciation_category')->nullable()->after('depreciation_type');
            $table->double('depreciation_value', 12, 2)->nullable()->after('depreciation_category');
            $table->double('current_purchase_value', 12, 2)->nullable()->after('depreciation_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('purchase_value');
            $table->dropColumn('is_depreciation');
            $table->dropColumn('depreciation_type');
            $table->dropColumn('depreciation_category');
            $table->dropColumn('depreciation_value');
            $table->dropColumn('current_purchase_value');
        });
    }
}
