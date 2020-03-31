<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdColumnToAssetCategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('asset_categories', function (Blueprint $table) {
            $table->bigInteger('user_id')->default(0)->after('admin_id');
        });
        Schema::table('asset_sub_categories', function (Blueprint $table) {
            $table->bigInteger('user_id')->default(0)->after('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('asset_categories', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('asset_sub_categories', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }

}
