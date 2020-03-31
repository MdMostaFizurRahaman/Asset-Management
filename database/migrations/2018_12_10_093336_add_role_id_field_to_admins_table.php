<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoleIdFieldToAdminsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('admins', function (Blueprint $table) {
            $table->integer('role_id')->default(0)->after('id');
            $table->integer('admin_id')->default(0)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('role_id');
            $table->dropColumn('admin_id');
        });
    }

}
