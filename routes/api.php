<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['vendorapiauth']], function () {
    Route::group([
        'namespace' => 'Api\Vendor\V1',
        'prefix' =>'vendor',
    ], function () {
        Route::prefix('v1')->group(function () {
            Route::post('login', 'ApiVendorController@login');
            Route::post('commonSync', 'ApiVendorController@commonSync');
            Route::group(['middleware' => ['auth:vendor-api']], function () {
                Route::post('update-password', 'ApiVendorController@updatePassword');
                Route::prefix('asset')->group(function () {
                    Route::post('info', 'ApiVendorController@assetInfo');
                    Route::post('assessment-list', 'ApiVendorController@assessmentList');
                    Route::post('assessment-create', 'ApiVendorController@assessmentCreate');
                });
            });
        });
    });
});


