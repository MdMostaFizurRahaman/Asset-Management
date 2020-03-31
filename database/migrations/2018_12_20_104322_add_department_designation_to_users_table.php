<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentDesignationToUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('company_id')->default(0)->after('id');
            $table->bigInteger('division_id')->default(0)->after('id');
            $table->bigInteger('department_id')->default(0)->after('id');
            $table->bigInteger('unit_id')->default(0)->after('id');
            $table->bigInteger('office_location_id')->default(0)->after('id');
            $table->bigInteger('designation_id')->default(0)->after('id');
            $table->bigInteger('user_id')->default(0)->after('admin_id');
            $table->string('phone')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('company_id');
            $table->dropColumn('division_id');
            $table->dropColumn('department_id');
            $table->dropColumn('unit_id');
            $table->dropColumn('office_location_id');
            $table->dropColumn('designation_id');
            $table->dropColumn('user_id');
            $table->dropColumn('phone');
        });
    }

}
