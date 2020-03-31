<?php

namespace App\Http\Controllers\admin;

use App\VendorPermissionCategory;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorPermissionController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-permissions-read'])) {
            $vendorpermissions = VendorPermissionCategory::orderBy('name', 'ASC')->paginate(20);
            return view('admin.vendor-permissions.index', compact('vendorpermissions'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function create() {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-permissions-create'])) {
            $stock_permission = DB::table('permission_vendor_permission_category')->pluck('permission_id')->all();
            $permissions = Permission::where('type', 3)->whereNotIn('id', $stock_permission)->orderBy('display_name', 'ASC')->pluck('display_name', 'id')->all();
            return view('admin.vendor-permissions.create', compact('permissions'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-permissions-create'])) {
            $messages = [
                    //
            ];

            $this->validate($request, [
                'name' => [
                    'required',
                    Rule::unique('vendor_permission_categories')->whereNull('deleted_at'),
                ],
                    ], $messages);

            $input = $request->all();

            $input['admin_id'] = Auth::guard('admin')->user()->id;

            $vendorpermission = VendorPermissionCategory::create($input);

            if ($request->get('permissions')) {
                $vendorpermission->permissions()->sync($request->get('permissions'));
            }

            Session::flash('success', 'The Vendor Permission has been created');

            return redirect()->route('admin.vendor-permissions.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-permissions-update'])) {
            $stock_permission = DB::table('permission_vendor_permission_category')->where('vendor_permission_category_id', '<>', $id)->pluck('permission_id')->all();
            $vendorpermission = VendorPermissionCategory::find($id);
            $permissions = Permission::where('type', 3)->whereNotIn('id', $stock_permission)->orderBy('display_name', 'ASC')->pluck('display_name', 'id')->all();
            $permissioncategory = [];

            foreach ($vendorpermission->permissions as $permission) {
                $permissioncategory[] = $permission->id;
            }
            return view('admin.vendor-permissions.edit', compact('vendorpermission', 'permissions', 'permissioncategory'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-permissions-update'])) {
            $rules = [
                'name' => [
                    'required',
                    Rule::unique('vendor_permission_categories')->whereNull('deleted_at')->ignore($id),
                ],
            ];

            $messages = [
                //
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();

            if (!$request->has('status')) {
                $input['status'] = 0;
            }
            $input['admin_id'] = Auth::guard('admin')->user()->id;

            $vendorpermission = VendorPermissionCategory::find($id);
            $vendorpermission->update($input);

            if ($request->get('permissions')) {
                $vendorpermission->permissions()->sync($request->get('permissions'));
            } else {
                $vendorpermission->permissions()->sync([]);
            }

            Session::flash('success', 'The Vendor Permission has been updated');

            return redirect()->route('admin.vendor-permissions.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-permissions-delete'])) {
            $vendorpermission = VendorPermissionCategory::find($id);
            $vendorpermission->update([
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $vendorpermission->permissions()->sync([]);
            $vendorpermission->delete();

            Session::flash('success', 'The Vendor Permission has been deleted');

            return redirect()->route('admin.vendor-permissions.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

}
