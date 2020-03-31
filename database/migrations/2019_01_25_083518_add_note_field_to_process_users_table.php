<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoteFieldToProcessUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('process_users', function (Blueprint $table) {
            $table->text('delete_user_id')->nullable()->after('user_id');
            $table->text('description')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('process_users', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('delete_user_id');
        });
    }

}
