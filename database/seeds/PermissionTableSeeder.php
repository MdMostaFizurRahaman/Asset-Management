<?php

use Illuminate\Database\Seeder;
use App\Permission;
use Carbon\Carbon;
use App\Role;

class PermissionTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*
         * Admin Permission
         */


        $exists = Role::where('type', 3)->where('name', 'vendor-admin')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Role::where('type', 3)->where('name', 'vendor-custom')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'admin-profile-read')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'admin-profile-update')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'company-profile-read')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'company-profile-update')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'vendor-profile-read')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'vendor-profile-update')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'admin-company-permissions-read')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'admin-company-permissions-update')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'admin-company-permissions-create')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'admin-company-permissions-delete')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'admin-companies-read')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'admin-companies-update')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'admin-companies-create')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'admin-companies-delete')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'company-asset-categories-read')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'company-asset-categories-update')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'company-asset-categories-create')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'company-asset-categories-delete')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'company-asset-subcategories-read')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'company-asset-subcategories-update')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'company-asset-subcategories-create')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'company-asset-subcategories-delete')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'admin-company-roles-read')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'admin-company-roles-update')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'admin-company-roles-create')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'admin-company-roles-delete')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'company-company-roles-read')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'company-company-roles-update')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'company-company-roles-create')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'company-company-roles-delete')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'admin-company-users-read')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'admin-company-users-update')->first();
        if ($exists) {
            $exists->delete();
        }

        $exists = Permission::where('name', 'admin-company-users-create')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'admin-company-users-delete')->first();
        if ($exists) {
            $exists->delete();
        }

        Permission::updateOrCreate([
            'name' => 'admin-admins-create',
        ], [
                'name' => 'admin-admins-create',
                'display_name' => 'Admin Create',
                'description' => 'Admin Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-admins-read',
        ], [
                'name' => 'admin-admins-read',
                'display_name' => 'Admin Read',
                'description' => 'Admin Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-admins-update',
        ], [
                'name' => 'admin-admins-update',
                'display_name' => 'Admin Update',
                'description' => 'Admin Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-admins-delete',
        ], [
                'name' => 'admin-admins-delete',
                'display_name' => 'Admin Delete',
                'description' => 'Admin Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-permissions-create',
        ], [
                'name' => 'admin-permissions-create',
                'display_name' => 'Permission Create',
                'description' => 'Permission Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-permissions-read',
        ], [
                'name' => 'admin-permissions-read',
                'display_name' => 'Permission Read',
                'description' => 'Permission Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-permissions-update',
        ], [
                'name' => 'admin-permissions-update',
                'display_name' => 'Permission Update',
                'description' => 'Permission Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-permissions-delete',
        ], [
                'name' => 'admin-permissions-delete',
                'display_name' => 'Permission Delete',
                'description' => 'Permission Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-vendor-permissions-create',
        ], [
                'name' => 'admin-vendor-permissions-create',
                'display_name' => 'Vendor Permission Create',
                'description' => 'Vendor Permission Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-vendor-permissions-read',
        ], [
                'name' => 'admin-vendor-permissions-read',
                'display_name' => 'Vendor Permission Read',
                'description' => 'Vendor Permission Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-vendor-permissions-update',
        ], [
                'name' => 'admin-vendor-permissions-update',
                'display_name' => 'Vendor Permission Update',
                'description' => 'Vendor Permission Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-vendor-permissions-delete',
        ], [
                'name' => 'admin-vendor-permissions-delete',
                'display_name' => 'Vendor Permission Delete',
                'description' => 'Vendor Permission Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-vendors-create',
        ], [
                'name' => 'admin-vendors-create',
                'display_name' => 'Vendor Create',
                'description' => 'Vendor Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-vendors-read',
        ], [
                'name' => 'admin-vendors-read',
                'display_name' => 'Vendor Read',
                'description' => 'Vendor Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-vendors-update',
        ], [
                'name' => 'admin-vendors-update',
                'display_name' => 'Vendor Update',
                'description' => 'Vendor Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-vendors-delete',
        ], [
                'name' => 'admin-vendors-delete',
                'display_name' => 'Vendor Delete',
                'description' => 'Vendor Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        // admin vendor info permission
        Permission::updateOrCreate([
            'name' => 'admin-vendor-infos-create',
        ], [
                'name' => 'admin-vendor-infos-create',
                'display_name' => 'Vendor Info Create',
                'description' => 'Vendor Info Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-vendor-infos-read',
        ], [
                'name' => 'admin-vendor-infos-read',
                'display_name' => 'Vendor Info Read',
                'description' => 'Vendor Info Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-vendor-infos-update',
        ], [
                'name' => 'admin-vendor-infos-update',
                'display_name' => 'Vendor Info Update',
                'description' => 'Vendor Info Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-vendor-infos-delete',
        ], [
                'name' => 'admin-vendor-infos-delete',
                'display_name' => 'Vendor Info Delete',
                'description' => 'Vendor Info Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );


        Permission::updateOrCreate([
            'name' => 'admin-client-permissions-create',
        ], [
                'name' => 'admin-client-permissions-create',
                'display_name' => 'Client Permission Create',
                'description' => 'Client Permission Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-client-permissions-read',
        ], [
                'name' => 'admin-client-permissions-read',
                'display_name' => 'Client Permission Read',
                'description' => 'Client Permission Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-client-permissions-update',
        ], [
                'name' => 'admin-client-permissions-update',
                'display_name' => 'Client Permission Update',
                'description' => 'Client Permission Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-client-permissions-delete',
        ], [
                'name' => 'admin-client-permissions-delete',
                'display_name' => 'Client Permission Delete',
                'description' => 'Client Permission Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-client-roles-create',
        ], [
                'name' => 'admin-client-roles-create',
                'display_name' => 'Client Role Create',
                'description' => 'Client Role Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-client-roles-read',
        ], [
                'name' => 'admin-client-roles-read',
                'display_name' => 'Client Role Read',
                'description' => 'Client Role Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-client-roles-update',
        ], [
                'name' => 'admin-client-roles-update',
                'display_name' => 'Client Role Update',
                'description' => 'Client Role Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-client-roles-delete',
        ], [
                'name' => 'admin-client-roles-delete',
                'display_name' => 'Client Role Delete',
                'description' => 'Client Role Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-vendor-roles-create',
        ], [
                'name' => 'admin-vendor-roles-create',
                'display_name' => 'Vendor Role Create',
                'description' => 'Vendor Role Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-vendor-roles-read',
        ], [
                'name' => 'admin-vendor-roles-read',
                'display_name' => 'Vendor Role Read',
                'description' => 'Vendor Role Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-vendor-roles-update',
        ], [
                'name' => 'admin-vendor-roles-update',
                'display_name' => 'Vendor Role Update',
                'description' => 'Vendor Role Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-vendor-roles-delete',
        ], [
                'name' => 'admin-vendor-roles-delete',
                'display_name' => 'Vendor Role Delete',
                'description' => 'Vendor Role Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-clients-create',
        ], [
                'name' => 'admin-clients-create',
                'display_name' => 'Client Create',
                'description' => 'Client Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-clients-read',
        ], [
                'name' => 'admin-clients-read',
                'display_name' => 'Client Read',
                'description' => 'Client Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-clients-update',
        ], [
                'name' => 'admin-clients-update',
                'display_name' => 'Client Update',
                'description' => 'Client Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-clients-delete',
        ], [
                'name' => 'admin-clients-delete',
                'display_name' => 'Client Delete',
                'description' => 'Client Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-client-users-create',
        ], [
                'name' => 'admin-client-users-create',
                'display_name' => 'Client User Create',
                'description' => 'Client User Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-client-users-read',
        ], [
                'name' => 'admin-client-users-read',
                'display_name' => 'Client User Read',
                'description' => 'Client User Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-client-users-update',
        ], [
                'name' => 'admin-client-users-update',
                'display_name' => 'Client User Update',
                'description' => 'Client User Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-client-users-delete',
        ], [
                'name' => 'admin-client-users-delete',
                'display_name' => 'Client User Delete',
                'description' => 'Client User Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-asset-categories-create',
        ], [
                'name' => 'admin-asset-categories-create',
                'display_name' => 'Asset Category Create',
                'description' => 'Asset Category Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-categories-read',
        ], [
                'name' => 'admin-asset-categories-read',
                'display_name' => 'Asset Category Read',
                'description' => 'Asset Category Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-categories-update',
        ], [
                'name' => 'admin-asset-categories-update',
                'display_name' => 'Asset Category Update',
                'description' => 'Asset Category Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-categories-delete',
        ], [
                'name' => 'admin-asset-categories-delete',
                'display_name' => 'Asset Category Delete',
                'description' => 'Asset Category Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-asset-categories-pending',
        ], [
                'name' => 'admin-asset-categories-pending',
                'display_name' => 'Asset Category Pending',
                'description' => 'Asset Category Pending',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-categories-approved',
        ], [
                'name' => 'admin-asset-categories-approved',
                'display_name' => 'Asset Category Approved',
                'description' => 'Asset Category Approved',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-asset-subcategories-create',
        ], [
                'name' => 'admin-asset-subcategories-create',
                'display_name' => 'Asset SubCategory Create',
                'description' => 'Asset SubCategory Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-subcategories-read',
        ], [
                'name' => 'admin-asset-subcategories-read',
                'display_name' => 'Asset SubCategory Read',
                'description' => 'Asset SubCategory Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-subcategories-update',
        ], [
                'name' => 'admin-asset-subcategories-update',
                'display_name' => 'Asset SubCategory Update',
                'description' => 'Asset SubCategory Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-subcategories-delete',
        ], [
                'name' => 'admin-asset-subcategories-delete',
                'display_name' => 'Asset SubCategory Delete',
                'description' => 'Asset SubCategory Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-subcategories-pending',
        ], [
                'name' => 'admin-asset-subcategories-pending',
                'display_name' => 'Asset SubCategory Pending',
                'description' => 'Asset SubCategory Pending',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-subcategories-approved',
        ], [
                'name' => 'admin-asset-subcategories-approved',
                'display_name' => 'Asset SubCategory Approved',
                'description' => 'Asset SubCategory Approved',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-asset-brands-create',
        ], [
                'name' => 'admin-asset-brands-create',
                'display_name' => 'Asset Brand Create',
                'description' => 'Asset Brand Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-brands-read',
        ], [
                'name' => 'admin-asset-brands-read',
                'display_name' => 'Asset Brand Read',
                'description' => 'Asset Brand Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-brands-update',
        ], [
                'name' => 'admin-asset-brands-update',
                'display_name' => 'Asset Brand Update',
                'description' => 'Asset Brand Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-brands-delete',
        ], [
                'name' => 'admin-asset-brands-delete',
                'display_name' => 'Asset Brand Delete',
                'description' => 'Asset Brand Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-brands-pending',
        ], [
                'name' => 'admin-asset-brands-pending',
                'display_name' => 'Asset Brand Pending',
                'description' => 'Asset Brand Pending',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-brands-approved',
        ], [
                'name' => 'admin-asset-brands-approved',
                'display_name' => 'Asset Brand Approved',
                'description' => 'Asset Brand Approved',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-asset-statuses-create',
        ], [
                'name' => 'admin-asset-statuses-create',
                'display_name' => 'Asset Status Create',
                'description' => 'Asset Status Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-statuses-read',
        ], [
                'name' => 'admin-asset-statuses-read',
                'display_name' => 'Asset Status Read',
                'description' => 'Asset Status Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-statuses-update',
        ], [
                'name' => 'admin-asset-statuses-update',
                'display_name' => 'Asset Status Update',
                'description' => 'Asset Status Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-statuses-delete',
        ], [
                'name' => 'admin-asset-statuses-delete',
                'display_name' => 'Asset Status Delete',
                'description' => 'Asset Status Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-asset-services-create',
        ], [
                'name' => 'admin-asset-services-create',
                'display_name' => 'Asset Service Create',
                'description' => 'Asset Service Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-services-read',
        ], [
                'name' => 'admin-asset-services-read',
                'display_name' => 'Asset Service Read',
                'description' => 'Asset Service Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-services-update',
        ], [
                'name' => 'admin-asset-services-update',
                'display_name' => 'Asset Service Update',
                'description' => 'Asset Service Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-services-delete',
        ], [
                'name' => 'admin-asset-services-delete',
                'display_name' => 'Asset Service Delete',
                'description' => 'Asset Service Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-asset-services-pending',
        ], [
                'name' => 'admin-asset-services-pending',
                'display_name' => 'Asset Service Pending',
                'description' => 'Asset Service Pending',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-services-approved',
        ], [
                'name' => 'admin-asset-services-approved',
                'display_name' => 'Asset Service Approved',
                'description' => 'Asset Service Approved',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-asset-hardwares-create',
        ], [
                'name' => 'admin-asset-hardwares-create',
                'display_name' => 'Asset Hardware Create',
                'description' => 'Asset Hardware Create',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-hardwares-read',
        ], [
                'name' => 'admin-asset-hardwares-read',
                'display_name' => 'Asset Hardware Read',
                'description' => 'Asset Hardware Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-hardwares-update',
        ], [
                'name' => 'admin-asset-hardwares-update',
                'display_name' => 'Asset Hardware Update',
                'description' => 'Asset Hardware Update',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-hardwares-delete',
        ], [
                'name' => 'admin-asset-hardwares-delete',
                'display_name' => 'Asset Hardware Delete',
                'description' => 'Asset Hardware Delete',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-asset-hardwares-pending',
        ], [
                'name' => 'admin-asset-hardwares-pending',
                'display_name' => 'Asset Hardware Pending',
                'description' => 'Asset Hardware Pending',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'admin-asset-hardwares-approved',
        ], [
                'name' => 'admin-asset-hardwares-approved',
                'display_name' => 'Asset Hardware Approved',
                'description' => 'Asset Hardware Approved',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-asset-read',
        ], [
                'name' => 'admin-asset-read',
                'display_name' => 'Asset Read',
                'description' => 'Asset Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'admin-assessments-read',
        ], [
                'name' => 'admin-assessments-read',
                'display_name' => 'Assessment Read',
                'description' => 'Assessment Read',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        /*
         * Client Permission
         */

        Permission::updateOrCreate([
            'name' => 'client-client-roles-create',
        ], [
                'name' => 'client-client-roles-create',
                'display_name' => 'Role Create',
                'description' => 'Role Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-client-roles-read',
        ], [
                'name' => 'client-client-roles-read',
                'display_name' => 'Role Read',
                'description' => 'Role Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-client-roles-update',
        ], [
                'name' => 'client-client-roles-update',
                'display_name' => 'Role Update',
                'description' => 'Role Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-client-roles-delete',
        ], [
                'name' => 'client-client-roles-delete',
                'display_name' => 'Role Delete',
                'description' => 'Role Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-companies-create',
        ], [
                'name' => 'client-companies-create',
                'display_name' => 'Company Create',
                'description' => 'Company Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-companies-read',
        ], [
                'name' => 'client-companies-read',
                'display_name' => 'Company Read',
                'description' => 'Company Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-companies-update',
        ], [
                'name' => 'client-companies-update',
                'display_name' => 'Company Update',
                'description' => 'Company Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-companies-delete',
        ], [
                'name' => 'client-companies-delete',
                'display_name' => 'Company Delete',
                'description' => 'Company Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-divisions-create',
        ], [
                'name' => 'client-divisions-create',
                'display_name' => 'Division Create',
                'description' => 'Division Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-divisions-read',
        ], [
                'name' => 'client-divisions-read',
                'display_name' => 'Division Read',
                'description' => 'Division Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-divisions-update',
        ], [
                'name' => 'client-divisions-update',
                'display_name' => 'Division Update',
                'description' => 'Division Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-divisions-delete',
        ], [
                'name' => 'client-divisions-delete',
                'display_name' => 'Division Delete',
                'description' => 'Division Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-departments-create',
        ], [
                'name' => 'client-departments-create',
                'display_name' => 'Department Create',
                'description' => 'Department Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-departments-read',
        ], [
                'name' => 'client-departments-read',
                'display_name' => 'Department Read',
                'description' => 'Department Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-departments-update',
        ], [
                'name' => 'client-departments-update',
                'display_name' => 'Department Update',
                'description' => 'Department Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-departments-delete',
        ], [
                'name' => 'client-departments-delete',
                'display_name' => 'Department Delete',
                'description' => 'Department Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-units-create',
        ], [
                'name' => 'client-units-create',
                'display_name' => 'Unit Create',
                'description' => 'Unit Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-units-read',
        ], [
                'name' => 'client-units-read',
                'display_name' => 'Unit Read',
                'description' => 'Unit Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-units-update',
        ], [
                'name' => 'client-units-update',
                'display_name' => 'Unit Update',
                'description' => 'Unit Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-units-delete',
        ], [
                'name' => 'client-units-delete',
                'display_name' => 'Unit Delete',
                'description' => 'Unit Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-office-locations-create',
        ], [
                'name' => 'client-office-locations-create',
                'display_name' => 'Office Location Create',
                'description' => 'Office Location Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-office-locations-read',
        ], [
                'name' => 'client-office-locations-read',
                'display_name' => 'Office Location Read',
                'description' => 'Office Location Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-office-locations-update',
        ], [
                'name' => 'client-office-locations-update',
                'display_name' => 'Office Location Update',
                'description' => 'Office Location Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-office-locations-delete',
        ], [
                'name' => 'client-office-locations-delete',
                'display_name' => 'Office Location Delete',
                'description' => 'Office Location Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-designations-create',
        ], [
                'name' => 'client-designations-create',
                'display_name' => 'Designation Create',
                'description' => 'Designation Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-designations-read',
        ], [
                'name' => 'client-designations-read',
                'display_name' => 'Designation Read',
                'description' => 'Designation Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-designations-update',
        ], [
                'name' => 'client-designations-update',
                'display_name' => 'Designation Update',
                'description' => 'Designation Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-designations-delete',
        ], [
                'name' => 'client-designations-delete',
                'display_name' => 'Designation Delete',
                'description' => 'Designation Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );


        Permission::updateOrCreate([
            'name' => 'client-users-create',
        ], [
                'name' => 'client-users-create',
                'display_name' => 'User Create',
                'description' => 'User Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-users-read',
        ], [
                'name' => 'client-users-read',
                'display_name' => 'User Read',
                'description' => 'User Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-users-update',
        ], [
                'name' => 'client-users-update',
                'display_name' => 'User Update',
                'description' => 'User Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-users-delete',
        ], [
                'name' => 'client-users-delete',
                'display_name' => 'User Delete',
                'description' => 'User Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-asset-categories-create',
        ], [
                'name' => 'client-asset-categories-create',
                'display_name' => 'Asset Category Create',
                'description' => 'Asset Category Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-categories-read',
        ], [
                'name' => 'client-asset-categories-read',
                'display_name' => 'Asset Category Read',
                'description' => 'Asset Category Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-categories-update',
        ], [
                'name' => 'client-asset-categories-update',
                'display_name' => 'Asset Category Update',
                'description' => 'Asset Category Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-categories-delete',
        ], [
                'name' => 'client-asset-categories-delete',
                'display_name' => 'Asset Category Delete',
                'description' => 'Asset Category Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-asset-subcategories-create',
        ], [
                'name' => 'client-asset-subcategories-create',
                'display_name' => 'Asset SubCategory Create',
                'description' => 'Asset SubCategory Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-subcategories-read',
        ], [
                'name' => 'client-asset-subcategories-read',
                'display_name' => 'Asset SubCategory Read',
                'description' => 'Asset SubCategory Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-subcategories-update',
        ], [
                'name' => 'client-asset-subcategories-update',
                'display_name' => 'Asset SubCategory Update',
                'description' => 'Asset SubCategory Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-subcategories-delete',
        ], [
                'name' => 'client-asset-subcategories-delete',
                'display_name' => 'Asset SubCategory Delete',
                'description' => 'Asset SubCategory Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-asset-tags-create',
        ], [
                'name' => 'client-asset-tags-create',
                'display_name' => 'Asset Tag Create',
                'description' => 'Asset Tag Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-tags-read',
        ], [
                'name' => 'client-asset-tags-read',
                'display_name' => 'Asset Tag Read',
                'description' => 'Asset Tag Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-tags-update',
        ], [
                'name' => 'client-asset-tags-update',
                'display_name' => 'Asset Tag Update',
                'description' => 'Asset Tag Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-tags-delete',
        ], [
                'name' => 'client-asset-tags-delete',
                'display_name' => 'Asset Tag Delete',
                'description' => 'Asset Tag Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-asset-brands-create',
        ], [
                'name' => 'client-asset-brands-create',
                'display_name' => 'Asset Brand Create',
                'description' => 'Asset Brand Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-brands-read',
        ], [
                'name' => 'client-asset-brands-read',
                'display_name' => 'Asset Brand Read',
                'description' => 'Asset Brand Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-brands-update',
        ], [
                'name' => 'client-asset-brands-update',
                'display_name' => 'Asset Brand Update',
                'description' => 'Asset Brand Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-brands-delete',
        ], [
                'name' => 'client-asset-brands-delete',
                'display_name' => 'Asset Brand Delete',
                'description' => 'Asset Brand Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-store-create',
        ], [
                'name' => 'client-store-create',
                'display_name' => 'Store Create',
                'description' => 'Store Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-store-read',
        ], [
                'name' => 'client-store-read',
                'display_name' => 'Store Read',
                'description' => 'Store Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-store-update',
        ], [
                'name' => 'client-store-update',
                'display_name' => 'Store Update',
                'description' => 'Store Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-store-delete',
        ], [
                'name' => 'client-store-delete',
                'display_name' => 'Store Delete',
                'description' => 'Store Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-assets-create',
        ], [
                'name' => 'client-assets-create',
                'display_name' => 'Asset Create',
                'description' => 'Asset Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-assets-read',
        ], [
                'name' => 'client-assets-read',
                'display_name' => 'Asset Read',
                'description' => 'Asset Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-assets-update',
        ], [
                'name' => 'client-assets-update',
                'display_name' => 'Asset Update',
                'description' => 'Asset Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-assets-delete',
        ], [
                'name' => 'client-assets-delete',
                'display_name' => 'Asset Delete',
                'description' => 'Asset Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-assets-archive',
        ], [
                'name' => 'client-assets-archive',
                'display_name' => 'Asset Archive',
                'description' => 'Asset Archive',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );


        Permission::updateOrCreate([
            'name' => 'client-workflows-create',
        ], [
                'name' => 'client-workflows-create',
                'display_name' => 'Workflow Create',
                'description' => 'Workflow Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-workflows-read',
        ], [
                'name' => 'client-workflows-read',
                'display_name' => 'Workflow Read',
                'description' => 'Workflow Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-workflows-update',
        ], [
                'name' => 'client-workflows-update',
                'display_name' => 'Workflow Update',
                'description' => 'Workflow Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-workflows-delete',
        ], [
                'name' => 'client-workflows-delete',
                'display_name' => 'Workflow Delete',
                'description' => 'Workflow Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );


        Permission::updateOrCreate([
            'name' => 'client-processes-create',
        ], [
                'name' => 'client-processes-create',
                'display_name' => 'Process Create',
                'description' => 'Process Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-processes-read',
        ], [
                'name' => 'client-processes-read',
                'display_name' => 'Process Read',
                'description' => 'Process Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-processes-update',
        ], [
                'name' => 'client-processes-update',
                'display_name' => 'Process Update',
                'description' => 'Process Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-processes-delete',
        ], [
                'name' => 'client-processes-delete',
                'display_name' => 'Process Delete',
                'description' => 'Process Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-processusers-create',
        ], [
                'name' => 'client-processusers-create',
                'display_name' => 'Process User Create',
                'description' => 'Process User Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-processusers-read',
        ], [
                'name' => 'client-processusers-read',
                'display_name' => 'Process User Read',
                'description' => 'Process User Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-processusers-delete',
        ], [
                'name' => 'client-processusers-delete',
                'display_name' => 'Process User Delete',
                'description' => 'Process User Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-asset-hardwares-create',
        ], [
                'name' => 'client-asset-hardwares-create',
                'display_name' => 'Asset Hardware Create',
                'description' => 'Asset Hardware Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-hardwares-read',
        ], [
                'name' => 'client-asset-hardwares-read',
                'display_name' => 'Asset Hardware Read',
                'description' => 'Asset Hardware Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-hardwares-update',
        ], [
                'name' => 'client-asset-hardwares-update',
                'display_name' => 'Asset Hardware Update',
                'description' => 'Asset Hardware Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-hardwares-delete',
        ], [
                'name' => 'client-asset-hardwares-delete',
                'display_name' => 'Asset Hardware Delete',
                'description' => 'Asset Hardware Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-asset-services-create',
        ], [
                'name' => 'client-asset-services-create',
                'display_name' => 'Asset Service Create',
                'description' => 'Asset Service Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-services-read',
        ], [
                'name' => 'client-asset-services-read',
                'display_name' => 'Asset Service Read',
                'description' => 'Asset Service Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-services-update',
        ], [
                'name' => 'client-asset-services-update',
                'display_name' => 'Asset Service Update',
                'description' => 'Asset Service Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-services-delete',
        ], [
                'name' => 'client-asset-services-delete',
                'display_name' => 'Asset Service Delete',
                'description' => 'Asset Service Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-assessments-read',
        ], [
                'name' => 'client-assessments-read',
                'display_name' => 'Assessment Read',
                'description' => 'Assessment Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-asset-return-create',
        ], [
                'name' => 'client-asset-return-create',
                'display_name' => 'Asset Return Create',
                'description' => 'Asset Return Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-return-read',
        ], [
                'name' => 'client-asset-return-read',
                'display_name' => 'Asset Return Read',
                'description' => 'Asset Return Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-return-update',
        ], [
                'name' => 'client-asset-return-update',
                'display_name' => 'Asset Return Update',
                'description' => 'Asset Return Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-asset-return-approval-create',
        ], [
                'name' => 'client-asset-return-approval-create',
                'display_name' => 'Asset Return Approval/Reject Create',
                'description' => 'Asset Return Approval/Reject Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-return-approval-read',
        ], [
                'name' => 'client-asset-return-approval-read',
                'display_name' => 'Asset Return Approval/Reject Read',
                'description' => 'Asset Return Approval/Reject Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'client-asset-return-approval-update',
        ], [
                'name' => 'client-asset-return-approval-update',
                'display_name' => 'Asset Return Approval/Reject Update',
                'description' => 'Asset Return Approval/Reject Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-attachment-delete',
        ], [
                'name' => 'client-attachment-delete',
                'display_name' => 'Attachment Delete',
                'description' => 'Attachment Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-vendor-enlistment-create',
        ], [
                'name' => 'client-vendor-enlistment-create',
                'display_name' => 'Vendor Enlistment Create',
                'description' => 'Vendor Enlistment Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-vendor-enlistment-read',
        ], [
                'name' => 'client-vendor-enlistment-read',
                'display_name' => 'Vendor Enlistment Read',
                'description' => 'Vendor Enlistment Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-vendor-enlistment-update',
        ], [
                'name' => 'client-vendor-enlistment-update',
                'display_name' => 'Vendor Enlistment Update',
                'description' => 'Vendor Enlistment Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-vendor-enlistment-delete',
        ], [
                'name' => 'client-vendor-enlistment-delete',
                'display_name' => 'Vendor Enlistment Delete',
                'description' => 'Vendor Enlistment Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-vendor-enlistment-attachment-delete',
        ], [
                'name' => 'client-vendor-enlistment-attachment-delete',
                'display_name' => 'Vendor Attachment Delete',
                'description' => 'Vendor Attachment Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-asset-permission-create',
        ], [
                'name' => 'client-asset-permission-create',
                'display_name' => 'Client Asset Permission Create',
                'description' => 'Client Asset Permission Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-asset-permission-read',
        ], [
                'name' => 'client-asset-permission-read',
                'display_name' => 'Client Asset Permission Read',
                'description' => 'Client Asset Permission Read',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-asset-permission-update',
        ], [
                'name' => 'client-asset-permission-update',
                'display_name' => 'Client Asset Permission Update',
                'description' => 'Client Asset Permission Update',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-asset-permission-delete',
        ], [
                'name' => 'client-asset-permission-delete',
                'display_name' => 'Client Asset Permission Delete',
                'description' => 'Client Asset Permission Delete',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'client-asset-permission-time-create',
        ], [
                'name' => 'client-asset-permission-time-create',
                'display_name' => 'Client Asset Permission Time Create',
                'description' => 'Client Asset Permission Time Create',
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        /*
         * Vendor Permission
         */

        Permission::updateOrCreate([
            'name' => 'vendor-vendor-roles-create',
        ], [
                'name' => 'vendor-vendor-roles-create',
                'display_name' => 'Role Create',
                'description' => 'Role Create',
                'type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'vendor-vendor-roles-read',
        ], [
                'name' => 'vendor-vendor-roles-read',
                'display_name' => 'Role Read',
                'description' => 'Role Read',
                'type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'vendor-vendor-roles-update',
        ], [
                'name' => 'vendor-vendor-roles-update',
                'display_name' => 'Role Update',
                'description' => 'Role Update',
                'type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'vendor-vendor-roles-delete',
        ], [
                'name' => 'vendor-vendor-roles-delete',
                'display_name' => 'Role Delete',
                'description' => 'Role Delete',
                'type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'vendor-users-create',
        ], [
                'name' => 'vendor-users-create',
                'display_name' => 'User Create',
                'description' => 'User Create',
                'type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'vendor-users-read',
        ], [
                'name' => 'vendor-users-read',
                'display_name' => 'User Read',
                'description' => 'User Read',
                'type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'vendor-users-update',
        ], [
                'name' => 'vendor-users-update',
                'display_name' => 'User Update',
                'description' => 'User Update',
                'type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'vendor-users-delete',
        ], [
                'name' => 'vendor-users-delete',
                'display_name' => 'User Delete',
                'description' => 'User Delete',
                'type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'vendor-clients-read',
        ], [
                'name' => 'vendor-clients-read',
                'display_name' => 'Client Read',
                'description' => 'Client Read',
                'type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        Permission::updateOrCreate([
            'name' => 'vendor-assessments-create',
        ], [
                'name' => 'vendor-assessments-create',
                'display_name' => 'Assessment Create',
                'description' => 'Assessment Create',
                'type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'vendor-assessments-read',
        ], [
                'name' => 'vendor-assessments-read',
                'display_name' => 'Assessment Read',
                'description' => 'Assessment Read',
                'type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'vendor-assessments-update',
        ], [
                'name' => 'vendor-assessments-update',
                'display_name' => 'Assessment Update',
                'description' => 'Assessment Update',
                'type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Permission::updateOrCreate([
            'name' => 'vendor-assessments-delete',
        ], [
                'name' => 'vendor-assessments-delete',
                'display_name' => 'Assessment Delete',
                'description' => 'Assessment Delete',
                'type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );


        /*
         * Admin Role
         */

        Role::updateOrCreate([
            'name' => 'admin',
        ], [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Admin Role',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Role::updateOrCreate([
            'name' => 'custom',
        ], [
                'name' => 'custom',
                'display_name' => 'Custom',
                'description' => 'Custom Role',
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

//        Role::updateOrCreate([
//            'name' => 'admin',
//                ], [
//            'name' => 'admin',
//            'display_name' => 'Admin',
//            'description' => 'Admin Role',
//            'type' => 3,
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//                ]
//        );
//        Role::updateOrCreate([
//            'name' => 'custom',
//                ], [
//            'name' => 'custom',
//            'display_name' => 'Custom',
//            'description' => 'Custom Role',
//            'type' => 3,
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//                ]
//        );

        /*
         * Client Role
         */

//        Role::updateOrCreate([
//            'name' => 'client-admin',
//                ], [
//            'name' => 'client-admin',
//            'display_name' => 'Admin',
//            'description' => 'Client Admin Role',
//            'type' => 2,
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//                ]
//        );
//        Role::updateOrCreate([
//            'name' => 'client-custom',
//                ], [
//            'name' => 'client-custom',
//            'display_name' => 'Custom',
//            'description' => 'Client Custom Role',
//            'type' => 2,
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//                ]
//        );

        /*
         * Vendor Role
         */

//        Role::updateOrCreate([
//            'name' => 'vendor-admin',
//                ], [
//            'name' => 'vendor-admin',
//            'display_name' => 'Admin',
//            'description' => 'Vendor Admin Role',
//            'type' => 3,
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//                ]
//        );
//        Role::updateOrCreate([
//            'name' => 'vendor-custom',
//                ], [
//            'name' => 'vendor-custom',
//            'display_name' => 'Custom',
//            'description' => 'Vendor Custom Role',
//            'type' => 3,
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//                ]
//        );
    }

}
