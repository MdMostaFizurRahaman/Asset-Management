<?php

namespace App\Http\Controllers\vendor;

use App\Helpers\Helper;
use App\Role;
use App\Vendor;
use App\VendorPermissionCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class VendorRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:vendor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-vendor-roles-read'])) {

            $roles = Role::where(['user_id' => Auth::guard('vendor')->user()->vendor_info_id, 'type' => 3])->orderBy('created_at', 'DESC')->paginate(20);
//            dd($roles);
            $vendor_assigned_role = Vendor::pluck('role_id', 'role_id')->all();
            return view('vendor.vendor-roles.index', compact('roles','vendor_assigned_role'));
        } else {
            return view('error.vendor-unauthorised');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-vendor-roles-create')) {
            $categories = VendorPermissionCategory::where('status', 1)->with('permissions')->get();
            return view('vendor.vendor-roles.create', compact('categories'));
        } else {
            return view('error.vendor-unauthorised');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-vendor-roles-create')) {

            $rules = [
                'display_name' => [
                    'required',
                    Rule::unique('roles')->where('user_id', Auth::guard('vendor')->user()->vendor_info_id)->where('type', 3),
                ],
                'description' => 'required',
                'permissions' => 'required',
            ];

            $messages = [
                'display_name.required' => 'Name field is required',
                'display_name.unique' => 'Name field is already exists',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();

            $input['name'] = strtolower('vendor-' . Str::slug($input['display_name']));
            $input['user_id'] = Auth::guard('vendor')->user()->vendor_info_id;
            $input['type'] = 3;

            $role = Role::create($input);

            if ($request->get('permissions')) {
                $role->permissions()->sync($request->get('permissions'));
            }

            Session::flash('success', 'The Role has been created');

            return redirect()->route('vendor.vendor-roles.index');
        } else {
            return view('error.vendor-unauthorised');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-vendor-roles-update')) {
            $role = Role::findOrFail($id);
            $categories = VendorPermissionCategory::where('status', 1)->with('permissions')->get();
            return view('vendor.vendor-roles.edit', compact('role', 'categories'));
        } else {
            return view('error.vendor-unauthorised');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-vendor-roles-update')) {

            $rules = [
                'display_name' => [
                    'required',
                    Rule::unique('roles')->where('user_id', Auth::guard('vendor')->user()->vendor_info_id)->where('type', 3)->ignore($id),
                ],
                'description' => 'required',
                'permissions' => 'required',
            ];

            $messages = [
                'display_name.required' => 'Name field is required',
                'display_name.unique' => 'Name field is already exists',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();

            $role = Role::findOrFail($id);

            if($role->name <> 'admin') {
                $input['name'] = strtolower('vendor-' . Str::slug($input['display_name']));
            }
            $role->update($input);

            if ($request->get('permissions')) {
                $role->permissions()->sync($request->get('permissions'));
            } else {
                $role->permissions()->sync([]);
            }

            Session::flash('success', 'The Role has been updated');

            return redirect()->route('vendor.vendor-roles.index');
        } else {
            return view('error.vendor-unauthorised');
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
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-vendor-roles-delete')) {
            // Role existence check in Vendor model
            $vendor_assigned_role = Vendor::pluck('role_id', 'role_id')->all();
            if (in_array($id, $vendor_assigned_role)) {
                Session::flash('warning', 'This Role already assigned an user');
                return redirect()->route('vendor.vendor-roles.index');
            }
            $role = Role::findOrFail($id);
            $role->permissions()->sync([]);
            $role->delete();
            Session::flash('success', 'The Role has been deleted');

            return redirect()->route('vendor.vendor-roles.index');
        } else {
            return view('error.vendor-unauthorised');
        }
    }
}
