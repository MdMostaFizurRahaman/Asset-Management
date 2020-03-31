<?php

namespace App\Http\Controllers\admin;

use App\ClientPermissionCategory;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientPermissionController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-permissions-read'])) {
            $clientpermissions = ClientPermissionCategory::orderBy('name', 'ASC')->paginate(20);
            return view('admin.client-permissions.index', compact('clientpermissions'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function create() {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-permissions-create'])) {
            $stock_permission = DB::table('client_permission_category_permission')->pluck('permission_id')->all();
            $permissions = Permission::where('type', 2)->whereNotIn('id', $stock_permission)->orderBy('display_name', 'ASC')->pluck('display_name', 'id')->all();
            return view('admin.client-permissions.create', compact('permissions'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-permissions-create'])) {
            $messages = [
                    //
            ];

            $this->validate($request, [
                'name' => [
                    'required',
                    Rule::unique('client_permission_categories')->whereNull('deleted_at'),
                ],
                    ], $messages);

            $input = $request->all();

            $input['admin_id'] = Auth::guard('admin')->user()->id;

            $clientpermission = ClientPermissionCategory::create($input);

            if ($request->get('permissions')) {
                $clientpermission->permissions()->sync($request->get('permissions'));
            }

            Session::flash('success', 'The Client Permission has been created');

            return redirect()->route('admin.client-permissions.index');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-permissions-update'])) {
            $stock_permission = DB::table('client_permission_category_permission')->where('client_permission_category_id', '<>', $id)->pluck('permission_id')->all();
            $clientpermission = ClientPermissionCategory::find($id);
            $permissions = Permission::where('type', 2)->whereNotIn('id', $stock_permission)->orderBy('display_name', 'ASC')->pluck('display_name', 'id')->all();
            $permissioncategory = [];

            foreach ($clientpermission->permissions as $permission) {
                $permissioncategory[] = $permission->id;
            }
            return view('admin.client-permissions.edit', compact('clientpermission', 'permissions', 'permissioncategory'));
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-permissions-update'])) {
            $rules = [
                'name' => [
                    'required',
                    Rule::unique('client_permission_categories')->whereNull('deleted_at')->ignore($id),
                ],
            ];

            $messages = [
                //
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            $input['admin_id'] = Auth::guard('admin')->user()->id;
            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $clientpermission = ClientPermissionCategory::find($id);
            $clientpermission->update($input);

            if ($request->get('permissions')) {
                $clientpermission->permissions()->sync($request->get('permissions'));
            } else {
                $clientpermission->permissions()->sync([]);
            }

            Session::flash('success', 'The Client Permission has been updated');

            return redirect()->route('admin.client-permissions.index');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-permissions-delete'])) {
            $clientpermission = ClientPermissionCategory::find($id);
            $clientpermission->update([
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $clientpermission->permissions()->sync([]);
            $clientpermission->delete();

            Session::flash('success', 'The Client Permission has been deleted');

            return redirect()->route('admin.client-permissions.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

}
