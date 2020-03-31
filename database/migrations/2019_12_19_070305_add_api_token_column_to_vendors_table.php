<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Vendor;

class AddApiTokenColumnToVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('api_token')->after('remember_token');
        });
        $vendors = Vendor::withTrashed()->get();
        foreach($vendors as $vendor) {
            $api_token = time() . str_random(30) . date("Ymd") . uniqid() . str_random(30);
            $vendor->update([
                'api_token' => $api_token,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('api_token');
        });
    }
}
