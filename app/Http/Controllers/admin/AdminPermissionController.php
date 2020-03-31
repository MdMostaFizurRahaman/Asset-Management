<?php

namespace App\Http\Controllers\admin;

use App\AdminPermissionCategory;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminPermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-permissions-read'])) {

            $adminpermissions = AdminPermissionCategory::orderBy('name', 'ASC')->paginate(20);
            //check existence
            $permission_admin_user = DB::table('permission_user')->where('user_type', 'App\Admin')->pluck('permission_id', 'permission_id')->all();
            $permission_category_ids = DB::table('admin_permission_category_permission')->whereIn('permission_id', $permission_admin_user)->pluck('admin_permission_category_id', 'admin_permission_category_id')->all();
            //end check existence

            return view('admin.admin-permissions.index', compact('adminpermissions', 'permission_category_ids'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function create()
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-permissions-create'])) {
            $stock_permission = DB::table('admin_permission_category_permission')->pluck('permission_id')->all();
            $permissions = Permission::where('type', 1)->whereNotIn('id', $stock_permission)->orderBy('display_name', 'ASC')->pluck('display_name', 'id')->all();
            return view('admin.admin-permissions.create', compact('permissions'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function store(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-permissions-create'])) {
            $messages = [
                //
            ];

            $this->validate($request, [
                'name' => [
                    'required',
                    Rule::unique('admin_permission_categories')->whereNull('deleted_at'),
                ],
            ], $messages);

            $input = $request->all();
            $input['admin_id'] = Auth::guard('admin')->user()->id;

            $adminpermission = AdminPermissionCategory::create($input);

            if ($request->get('permissions')) {
                $adminpermission->permissions()->sync($request->get('permissions'));
            }

            Session::flash('success', 'The Admin Permission has been created');

            return redirect()->route('admin.admin-permissions.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-permissions-update'])) {
            //check existence
            $permission_category = DB::table('admin_permission_category_permission')->where('admin_permission_category_id', $id)->pluck('permission_id', 'permission_id')->all();
            $permission_admin_user = DB::table('permission_user')->where('user_type', 'App\Admin')->pluck('permission_id', 'permission_id')->all();
            $result = array_intersect($permission_category, $permission_admin_user);
            if ($result) {
                Session::flash('warning', 'This Permission Category already assigned an user');
                return redirect()->route('admin.admin-permissions.index');
            }
            //end check existence
            $stock_permission = DB::table('admin_permission_category_permission')->where('admin_permission_category_id', '<>', $id)->pluck('permission_id')->all();
            $adminpermission = AdminPermissionCategory::find($id);
            $permissions = Permission::where('type', 1)->whereNotIn('id', $stock_permission)->orderBy('display_name', 'ASC')->pluck('display_name', 'id')->all();
            $permissioncategory = [];

            foreach ($adminpermission->permissions as $permission) {
                $permissioncategory[] = $permission->id;
            }
            return view('admin.admin-permissions.edit', compact('adminpermission', 'permissions', 'permissioncategory'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-permissions-update'])) {
            //check existence
            $permission_category = DB::table('admin_permission_category_permission')->where('admin_permission_category_id', $id)->pluck('permission_id', 'permission_id')->all();
            $permission_admin_user = DB::table('permission_user')->where('user_type', 'App\Admin')->pluck('permission_id', 'permission_id')->all();
            $result = array_intersect($permission_category, $permission_admin_user);
            if ($result) {
                Session::flash('warning', 'This Permission Category already assigned an user');
                return redirect()->route('admin.admin-permissions.index');
            }
            //end check existence

            $rules = [
                'name' => [
                    'required',
                    Rule::unique('admin_permission_categories')->whereNull('deleted_at')->ignore($id),
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

            $adminpermission = AdminPermissionCategory::find($id);
            $adminpermission->update($input);

            if ($request->get('permissions')) {
                $adminpermission->permissions()->sync($request->get('permissions'));
            } else {
                $adminpermission->permissions()->sync([]);
            }

            Session::flash('success', 'The Admin Permission has been updated');

            return redirect()->route('admin.admin-permissions.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-permissions-delete'])) {
            //check existence
            $permission_category = DB::table('admin_permission_category_permission')->where('admin_permission_category_id', $id)->pluck('permission_id', 'permission_id')->all();
            $permission_admin_user = DB::table('permission_user')->where('user_type', 'App\Admin')->pluck('permission_id', 'permission_id')->all();
            $result = array_intersect($permission_category, $permission_admin_user);
            if ($result) {
                Session::flash('warning', 'This Permission Category already assigned an admin user');
                return redirect()->route('admin.admin-permissions.index');
            }
            //end check existence

            $adminpermission = AdminPermissionCategory::find($id);
            $adminpermission->update([
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $adminpermission->permissions()->sync([]);
            $adminpermission->delete();

            Session::flash('success', 'The Admin Permission has been deleted');

            return redirect()->route('admin.admin-permissions.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

}
