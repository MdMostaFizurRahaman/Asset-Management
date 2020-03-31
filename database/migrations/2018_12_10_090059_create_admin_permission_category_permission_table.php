<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPermissionCategoryPermissionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('admin_permission_category_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_permission_category_id');
            $table->integer('permission_id');
        });

        Schema::create('permission_vendor_permission_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_permission_category_id');
            $table->integer('permission_id');
        });

        Schema::create('company_permission_category_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_permission_category_id');
            $table->integer('permission_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('admin_permission_category_permission');
        Schema::dropIfExists('permission_vendor_permission_category');
        Schema::dropIfExists('company_permission_category_permission');
    }

}
