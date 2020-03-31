<?php

namespace App\Http\Controllers\admin;

use App\Client;
use App\ClientPermissionCategory;
use App\Helpers\Helper;
use App\Role;
use App\Vendor;
use App\VendorInfo;
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
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $vendorId
     * @return \Illuminate\Http\Response
     */

    public function index($vendorId)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-roles-read'])) {
            $vendorinfo = VendorInfo::findOrFail($vendorId);
            $categories = VendorPermissionCategory::where('status', 1)->orderBy('name', 'ASC')->with('permissions')->get();
            return view('admin.vendor-roles.index', compact('vendorinfo', 'categories'));
        } else {
            return view('error.admin-unauthorised');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $vendorId
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store($vendorId, Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-roles-create'])) {

            $rules = [
                'display_name' => [
                    'required',
                    Rule::unique('roles')->where('user_id', $vendorId)->where('type', 3),
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
            $input['user_id'] = $vendorId;
            $input['type'] = 3;

            $role = Role::create($input);

            if ($request->get('permissions')) {
                $role->permissions()->sync($request->get('permissions'));
            }

            Session::flash('success', 'The Role has been created');

            return redirect()->route('admin.vendor-roles.index', $vendorId);
        } else {
            return view('error.admin-unauthorised');
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
    public function edit($vendorId, $id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-roles-update'])) {
            $role = Role::findOrFail($id);
            $categories = VendorPermissionCategory::where('status', 1)->orderBy('name', 'ASC')->with('permissions')->get();
            return view('admin.vendor-roles.edit', compact('role', 'categories'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $vendorId
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($vendorId, $id, Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-roles-update'])) {

            $rules = [
                'display_name' => [
                    'required',
                    Rule::unique('roles')->where('user_id', $vendorId)->where('type', 3)->ignore($id),
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

            if ($role->name <> 'admin') {
                $input['name'] = strtolower('vendor-' . Str::slug($input['display_name']));
            }

            $role->update($input);

            if ($request->get('permissions')) {
                $role->permissions()->sync($request->get('permissions'));
            } else {
                $role->permissions()->sync([]);
            }

            Session::flash('success', 'The Role has been updated');

            return redirect()->route('admin.vendor-roles.index', $vendorId);

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
    public function destroy($vendorId, $id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-roles-delete'])) {

            $role = Role::findOrFail($id);
            // Role existence check in User model
            $user_assigned_role = Vendor::pluck('role_id', 'role_id')->all();
            if (in_array($id, $user_assigned_role)) {
                Session::flash('warning', 'This Role already assigned a Vendor.');
                return redirect()->back();
            }

            $role->permissions()->sync([]);
            $role->delete();

            Session::flash('success', 'The Role has been deleted');

            return redirect()->back();
        } else {
            return view('error.admin-unauthorised');
        }
    }
}
