<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCompanyTableToClientTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('companies', function (Blueprint $table) {
            $table->renameColumn('company_website', 'client_website');
            $table->renameColumn('company_url', 'client_url');
        });

        Schema::table('company_permission_category_permission', function (Blueprint $table) {
            $table->renameColumn('company_permission_category_id', 'client_permission_category_id');
        });

        Schema::table('asset_categories', function (Blueprint $table) {
            $table->renameColumn('company_id', 'client_id');
        });

        Schema::table('asset_sub_categories', function (Blueprint $table) {
            $table->renameColumn('company_id', 'client_id');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('company_id', 'client_id');
        });
        
        Schema::rename('companies', 'clients');
        Schema::rename('company_permission_categories', 'client_permission_categories');
        Schema::rename('company_permission_category_permission', 'client_permission_category_permission');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('clients', function (Blueprint $table) {
            $table->renameColumn('client_website', 'company_website');
            $table->renameColumn('client_url', 'company_url');
        });

        Schema::table('client_permission_category_permission', function (Blueprint $table) {
            $table->renameColumn('client_permission_category_id', 'company_permission_category_id');
        });
        
        Schema::table('asset_categories', function (Blueprint $table) {
            $table->renameColumn('client_id', 'company_id');
        });

        Schema::table('asset_sub_categories', function (Blueprint $table) {
            $table->renameColumn('client_id', 'company_id');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('client_id', 'company_id');
        });

        Schema::rename('clients', 'companies');
        Schema::rename('client_permission_categories', 'company_permission_categories');
        Schema::rename('client_permission_category_permission', 'company_permission_category_permission');
    }

}
