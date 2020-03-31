<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveRoleIdPasswordFieldFromCompaniesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('role_id');
            $table->dropColumn('password');
            $table->renameColumn('company_web_url', 'company_website');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('companies', function (Blueprint $table) {
            $table->integer('role_id')->default(0);
            $table->string('password');
            $table->renameColumn('company_website', 'company_web_url');
        });
    }

}
