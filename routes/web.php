<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

use Illuminate\Support\Facades\Route;

//Main Domain Access Deny
Route::domain(env('APP_DOMAIN_URL'))->group(function () {
    Route::any('/', function () {
        return view('error.unauthorised');
    });
});

Route::domain('admin.' . env('APP_DOMAIN_URL'))->group(function () {
// For Cache Clear
    Route::get('/clear-cache', function () {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return view('error.clear-cache'); //Return anything
    });
    Route::get('/home', function () {
        return redirect('/');
    });
    Route::get('/page-not-found', 'ErrorHandlerController@admin404')->middleware('auth:admin')->name('admin.404');
    Route::group(['namespace' => 'admin'], function () {
        /*
         * Admin User Route
         */

        /*
         * Ajax route
         */
        Route::post('workflow/getAssets', 'AjaxController@getAssets')->name('admin.workflow.getAssets');
        Route::post('getWorkflows', 'AjaxController@getWorkflows')->name('admin.getWorkflows');
        Route::post('client/roles', 'AjaxController@getClientRoles')->name('admin.client.roles');
        Route::post('vendor/roles', 'AjaxController@getVendorRoles')->name('admin.vendor.roles');
        Route::post('getDesignations', 'AjaxController@getDesignations')->name('admin.client.getDesignations');
        Route::post('getLocations', 'AjaxController@getLocations')->name('admin.client.getLocations');
        Route::post('getUnits', 'AjaxController@getUnits')->name('admin.client.getUnits');
        Route::post('getDepartments', 'AjaxController@getDepartments')->name('admin.client.getDepartments');
        Route::post('getDivisions', 'AjaxController@getDivisions')->name('admin.client.getDivisions');
        Route::post('getCompanies', 'AjaxController@getCompanies')->name('admin.client.getCompanies');

        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.forgot');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
        Route::post('password/reset', 'ResetPasswordController@reset');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');

        Route::get('login', 'AdminLoginController@showLogin')->name('admin.login');
        Route::post('login', 'AdminLoginController@login')->name('admin.login.submit');
        Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');
        Route::get('logout', 'AdminLoginController@logout')->name('admin.logout');

        Route::get('editPassword', 'AdminController@password')->name('admin.editPassword');
        Route::post('editPassword', 'AdminController@passwordUpdate');

        Route::get('admin/resetPassword/{id}', 'AdminController@resetPassword')->name('admin.admins.resetPassword');
        Route::patch('admin/resetPassword/{id}', 'AdminController@resetPasswordStore');

        Route::resource('admins', 'AdminController', [
            'as' => 'admin'
        ]);

        Route::resource('admin-permissions', 'AdminPermissionController', [
            'as' => 'admin'
        ]);

        Route::resource('vendor-permissions', 'VendorPermissionController', [
            'as' => 'admin'
        ]);
        Route::resource('client-permissions', 'ClientPermissionController', [
            'as' => 'admin'
        ]);

        Route::group(['prefix' => '{id}'], function () {
            Route::resource('pendinglist', 'ClientRoleController', [
                'as' => 'admin'
            ]);
        });

        Route::group(['prefix' => '{id}'], function () {
            Route::resource('client-roles', 'ClientRoleController', [
                'as' => 'admin'
            ]);
        });

        Route::resource('clients', 'ClientController', [
            'as' => 'admin'
        ]);

        Route::get('client-users/resetPassword/{id}', 'ClientUserController@resetPassword')->name('admin.client-users.resetPassword');
        Route::patch('client-users/resetPassword/{id}', 'ClientUserController@resetPasswordStore');

        Route::resource('client-users', 'ClientUserController', [
            'as' => 'admin'
        ]);

        Route::resource('vendors', 'VendorInfoController', [
            'as' => 'admin'
        ]);
        Route::get('vendor-users/resetPassword/{id}', 'VendorController@resetPassword')->name('admin.vendor-users.resetPassword');
        Route::patch('vendor-users/resetPassword/{id}', 'VendorController@resetPasswordStore');

        Route::resource('vendor-users', 'VendorController', [
            'as' => 'admin'
        ]);
        Route::post('getVendor', 'AjaxController@getVendor')->name('admin.vendor.getVendor');

        Route::group(['prefix' => '{id}'], function () {
            Route::resource('vendor-roles', 'VendorRoleController', [
                'as' => 'admin'
            ]);
        });
        Route::get('asset-categories/pendings', 'AssetCategoryController@pending')->name('admin.asset-categories.pending');
        Route::patch('asset-categories/pendings/{id}', 'AssetCategoryController@approved')->name('admin.asset-categories.approved');
        Route::resource('asset-categories', 'AssetCategoryController', [
            'as' => 'admin'
        ]);

        Route::get('asset-subcategories/pendings', 'AssetSubCategoryController@pending')->name('admin.asset-subcategories.pending');
        Route::patch('asset-subcategories/pendings/{id}', 'AssetSubCategoryController@approved')->name('admin.asset-subcategories.approved');
        Route::resource('asset-subcategories', 'AssetSubCategoryController', [
            'as' => 'admin'
        ]);

        Route::get('asset-brands/pendings', 'AssetBrandController@pending')->name('admin.asset-brands.pending');
        Route::patch('asset-brands/pendings/{id}', 'AssetBrandController@approved')->name('admin.asset-brands.approved');
        Route::resource('asset-brands', 'AssetBrandController', [
            'as' => 'admin'
        ]);

        Route::resource('asset-statuses', 'AssetStatusController', [
            'as' => 'admin'
        ]);

        Route::get('asset-services/pendings', 'AssetServiceController@pending')->name('admin.asset-services.pending');
        Route::patch('asset-services/pendings/{id}', 'AssetServiceController@approved')->name('admin.asset-services.approved');
        Route::resource('asset-services', 'AssetServiceController', [
            'as' => 'admin'
        ]);

        Route::get('asset-accessories/pendings', 'AssetAccessoryController@pending')->name('admin.asset-accessories.pending');
        Route::patch('asset-accessories/pendings/{id}', 'AssetAccessoryController@approved');
        Route::resource('asset-accessories', 'AssetAccessoryController', [
            'as' => 'admin'
        ]);
        //Asset
        Route::post('getsubcategories', 'AssetController@subcategories')->name('admin.getsubcategories');
        Route::get('assets', 'AssetController@index')->name('admin.assets.index');
        Route::get('assets/archive', 'AssetController@archive')->name('admin.assets.archive');
        Route::get('assets/{id}', 'AssetController@show')->name('admin.assets.show');

        Route::get('assessments', 'AssessmentController@index')->name('admin.assessments.index');
        Route::get('assessments/timeline/{id}', 'AssessmentController@timeline')->name('admin.assessments.timeline');
    });
});


Route::domain('vendor.' . env('APP_DOMAIN_URL'))->group(function () {

    Route::get('/home', function () {
        return redirect('/');
    });
    Route::get('/page-not-found', 'ErrorHandlerController@vendor404')->middleware('auth:vendor')->name('vendor.404');
    Route::group(['namespace' => 'vendor'], function () {
        /*
         * Vendor User Route
        */
        Route::resource('vendor-roles', 'VendorRoleController', [
            'as' => 'vendor'
        ]);
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('vendor.password.forgot');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('vendor.password.email');
        Route::post('password/reset', 'ResetPasswordController@reset');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('vendor.password.reset');

        Route::get('login', 'VendorLoginController@showLogin')->name('vendor.login');
        Route::post('login', 'VendorLoginController@login')->name('vendor.login.submit');
        Route::get('/', 'VendorController@dashboard')->name('vendor.dashboard');
        Route::get('logout', 'VendorLoginController@logout')->name('vendor.logout');

        Route::get('editPassword', 'VendorController@password')->name('vendor.editPassword');
        Route::post('editPassword', 'VendorController@passwordUpdate');

        Route::resource('clients', 'ClientController', [
            'as' => 'vendor'
        ]);

        Route::get('vendors/resetPassword/{id}', 'VendorUserController@resetPassword')->name('vendors.resetPassword');
        Route::patch('vendor/resetPassword/{id}', 'VendorUserController@resetPasswordStore');
        Route::resource('vendors', 'VendorUserController', [
            'as' => 'vendor'
        ]);

        Route::get('assessments/services/{client}/{id}', 'AssessmentController@services')->name('vendor.assessments.services');
        Route::patch('assessments/services/{client}/{id}', 'AssessmentController@servicestore');

        Route::group(['prefix' => '{id}'], function () {
            Route::resource('assessments', 'AssessmentController', [
                'as' => 'vendor'
            ]);
        });


    });
});


Route::domain('{subdomain}.' . env('APP_DOMAIN_URL'))->group(function () {

    Route::get('/home', function () {
        return redirect('/');
    });
    Route::get('/page-not-found', 'ErrorHandlerController@client404')->middleware('auth:web')->name('client.404');
    Route::group(['namespace' => 'client'], function () {

        /*
         * Client User Route
         */

        /*
         * Ajax route
         */

        Route::post('workflow/getAssets', 'AjaxController@getAssets')->name('client.workflow.getAssets');

        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('client.password.forgot');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('client.password.email');
        Route::post('password/reset', 'ResetPasswordController@reset');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('client.password.reset');

        Route::get('login', 'ClientLoginController@showLogin')->name('client.login');
        Route::post('login', 'ClientLoginController@login')->name('client.login.submit');
        Route::get('/', 'ClientController@dashboard')->name('client.dashboard');
        Route::get('logout', 'ClientLoginController@logout')->name('client.logout');

        Route::get('editPassword', 'ClientController@password')->name('client.editPassword');
        Route::post('editPassword', 'ClientController@passwordUpdate');
        Route::get('details', 'ClientController@details')->name('client.details');
        // asset return
        Route::get('asset/{id}/return', 'ClientController@assetedit')->name('client.assetreturn');
        Route::post('assetreturn/{id}', 'ClientController@assetupdate');
        //asset accept
        Route::post('assetaccept/{id}', 'ClientController@assetacceptstore');
        //asset reject
        Route::get('asset/{id}/reject', 'ClientController@assetreject')->name('client.assetreject');
        Route::post('assetreject/{id}', 'ClientController@assetrejectstore');

        Route::resource('client-roles', 'ClientRoleController', [
            'as' => 'client'
        ]);

        Route::resource('companies', 'CompanyController', [
            'as' => 'client'
        ]);

        Route::resource('divisions', 'DivisionController', [
            'as' => 'client'
        ]);

        Route::resource('departments', 'DepartmentController', [
            'as' => 'client'
        ]);

        Route::resource('units', 'UnitController', [
            'as' => 'client'
        ]);

        Route::resource('designations', 'DesignationController', [
            'as' => 'client'
        ]);

        Route::resource('office-locations', 'OfficeLocationController', [
            'as' => 'client'
        ]);

        Route::get('users/resetPassword/{id}', 'UserController@resetPassword')->name('client.users.resetPassword');
        Route::patch('users/resetPassword/{id}', 'UserController@resetPasswordStore');

        Route::resource('users', 'UserController', [
            'as' => 'client'
        ]);

        Route::resource('asset-categories', 'AssetCategoryController', [
            'as' => 'client'
        ]);

        Route::resource('asset-subcategories', 'AssetSubCategoryController', [
            'as' => 'client'
        ]);
        Route::post('asset-store', 'AssetController@assetstore')->name('client.assetstore');
        Route::resource('stores', 'StoreController', [
            'as' => 'client'
        ]);
        Route::resource('asset-tags', 'AssetTagController', [
            'as' => 'client'
        ]);

        Route::resource('asset-brands', 'AssetBrandController', [
            'as' => 'client'
        ]);

        Route::post('getsubcategories', 'AssetController@subcategories')->name('client.getsubcategories');
        Route::get('assets/archive', 'AssetController@archive')->name('client.assets.archive');
        //Asset Return Rejection Accept
        Route::post('asset-return-accept/{id}', 'AssetController@returnaccept');
        Route::get('asset/{id}/return-reject', 'AssetController@returnreject')->name('client.return.reject');
        Route::post('asset/return-reject/{id}', 'AssetController@returnrejectstore');
        //Asset Assign
        Route::get('assets/{id}/assign', 'AssetController@assignuser')->name('client.assets.assignuser');
        Route::post('assets/assign/{id}', 'AssetController@assignuserstore');
        //Asset Move Order
        Route::get('assets/{id}/move-order', 'AssetController@moveorder')->name('client.assets.move.order');
        Route::post('assets/move-order/{id}', 'AssetController@moveorderstore');
        //Asset Logs
        Route::get('assets/{id}/logs', 'AssetController@assetlogs')->name('client.assets.logs');

        //Asset attachment
        Route::get('assets/{id}/attach-file', 'AssetController@attachfile')->name('client.assets.attach.file');
        Route::post('assets/attach-file/{id}', 'AssetController@attachfilestore');
        Route::delete('assets/attach-file/{id}', 'AssetController@attachmentdestroy');
        //Asset permission to Vendor
        Route::get('assets/{id}/vendor-permission', 'AssetController@vendorpermission')->name('client.assets.vendor.permission');
        Route::post('assets/vendor-permission/{id}', 'AssetController@vendorpermissionstore');
        Route::delete('assets/vendor-permission/{id}', 'AssetController@vendorpermissiondestroy');

        //Asset permission time
        Route::get('assets/{id}/vendor-permission-time', 'AssetController@vendorpermissiontime')->name('client.assets.vendor.permission.time');
        Route::post('assets/vendor-permission-time/{id}', 'AssetController@vendorpermissiontimestore');
        Route::post('assets/vendor-permission-time-remove/{id}', 'AssetController@permissiontimeremove');

        Route::resource('assets', 'AssetController', [
            'as' => 'client'
        ]);

        Route::resource('workflows', 'WorkflowController', [
            'as' => 'client'
        ]);

        Route::group(['prefix' => '{id}'], function () {
            Route::resource('processes', 'ProcessController', [
                'as' => 'client'
            ]);
        });

        Route::group(['prefix' => '{id}'], function () {
            Route::resource('processusers', 'ProcessUserController', [
                'as' => 'client'
            ]);
        });

        Route::resource('asset-services', 'AssetServiceController', [
            'as' => 'client'
        ]);

        Route::resource('asset-accessories', 'AssetAccessoryController', [
            'as' => 'client'
        ]);

        Route::get('assessments/pendinglist', 'AssessmentController@pendinglist')->name('client.assessments.pendinglist');
        Route::get('assessments/approvelist', 'AssessmentController@approvelist')->name('client.assessments.approvelist');
        Route::get('assessments/rejectlist', 'AssessmentController@rejectlist')->name('client.assessments.rejectlist');
        //Aproval or Reject
        Route::get('assessments/approvalreject/{id}', 'AssessmentController@approvalreject')->name('client.assessments.approvalreject');
        Route::patch('assessments/approvalreject/{id}', 'AssessmentController@approvalrejectstore');

        Route::get('assessments', 'AssessmentController@index')->name('client.assessments.index');
        Route::get('assessments/timeline/{id}', 'AssessmentController@timeline')->name('client.assessments.timeline');

        //Vendor Enlistment
        Route::get('vendor-enlistments/list', 'VendorEnlistmentController@vendor')->name('client.vendor-enlistments.list');

        Route::group(['prefix' => '{id}'], function () {
            Route::resource('vendor-enlistments', 'VendorEnlistmentController', [
                'as' => 'client'
            ])->only('create', 'store');
        });
        Route::resource('vendor-enlistments', 'VendorEnlistmentController', [
            'as' => 'client'
        ])->except('create', 'store');

        //Asset Attachment
        Route::get('vendor-enlistments/{id}/attach-file', 'VendorEnlistmentController@attachfile')->name('client.vendor-enlistments.attach.file');
        Route::post('vendor-enlistments/attach-file/{id}', 'VendorEnlistmentController@attachfilestore');
        Route::delete('vendor-enlistments/attach-file/{id}', 'VendorEnlistmentController@attachmentdestroy');
        //Client Asset Permission
        Route::get('vendor-enlistments/{id}/asset-permission', 'VendorEnlistmentController@assetpermission')->name('client.vendor-enlistments.asset.permission');
        Route::post('vendor-enlistments/asset-permission/{id}', 'VendorEnlistmentController@assetpermissionstore');
    });
});

