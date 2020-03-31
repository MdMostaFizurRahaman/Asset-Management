<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeFieldToPermissionsRolesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('roles', function (Blueprint $table) {
            $table->tinyInteger('type')->default(0)->after('id');
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->tinyInteger('type')->default(0)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }

}
