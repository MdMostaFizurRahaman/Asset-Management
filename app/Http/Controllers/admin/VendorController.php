<?php

namespace App\Http\Controllers\admin;

use App\Vendor;
use App\Role;
use App\VendorInfo;
use App\VendorPermissionCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendors-read'])) {

            $vendors = Vendor::orderBy('name', 'ASC');

            if ($request->get('name')) {
                $vendors->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('email')) {
                $vendors->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }

            if ($request->get('role')) {
                $vendors->where('role_id', $request->get('role'));
            }

            $vendors = $vendors->with(['role', 'vendorInfo'])->paginate(50);

            $roles = Role::where('type', 3)->pluck('display_name', 'id')->all();

            return view('admin.vendor-users.index', compact('vendors', 'roles'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function create()
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendors-create'])) {
            $vendors_info = VendorInfo::where('status', 1)->pluck('name', 'id')->all();
            $roles = [];
            $vendorId = '';
            if (old('vendor_info_id')) {
                $roles = Role::where([['type', 3], ['user_id', old('vendor_info_id')]])->pluck('display_name', 'id')->all();
                $vendorId = VendorInfo::where('id', old('vendor_info_id'))->first()->vendor_id;
            }
            return view('admin.vendor-users.create', compact('roles', 'vendors_info', 'vendorId'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function store(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendors-create'])) {

            $messages = [
                'vendor_info_id.required' => 'Vendor Name field is required',
                'role_id.required' => 'Role field is required',
                'name.required' => 'Name field is required',
                'email.required' => 'Email field is required',
                'email.unique' => 'Email already exists',
                'password.required' => 'Password field is required',
                'password_confirmation.required' => 'Confirm Password field is required',
            ];

            $this->validate($request, [
                'vendor_info_id' => 'required',
                'role_id' => 'required',
                'name' => 'required',
                'username' => [
                    'required',
                    'alpha_num',
                    Rule::unique('vendors', 'username')->where('vendor_info_id', $request->vendor_info_id)
                ],
                'email' => 'nullable|sometimes|email',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ], $messages);

            $input = $request->all();

            unset($input['password_confirmation']);

            $input['password'] = bcrypt($request->get('password'));
            $input['admin_id'] = Auth::guard('admin')->user()->id;
            $input['api_token'] = time() . str_random(30) . date("Ymd") . uniqid() . str_random(30);
//            dd($input);
            $vendor = Vendor::create($input);

            if ($vendor->role->name != 'admin') {
                if ($request->get('permissions')) {
                    $vendor->permissions()->sync($request->get('permissions'));
                }
            }

            $vendor->attachRole($input['role_id']);

            Session::flash('success', 'The Vendor User has been created');

            return redirect()->route('admin.vendor-users.index');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendors-update'])) {
            $vendor = Vendor::find($id);
            $categories = VendorPermissionCategory::where('status', 1)->with('permissions')->get();

            $roles = Role::where([['type', 3], ['user_id', $vendor->vendor_info_id]])->pluck('display_name', 'id')->all();

            return view('admin.vendor-users.edit', compact('vendor', 'categories', 'roles'));
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

        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendors-update'])) {
            $vendor = Vendor::findOrFail($id);
            $rules = [
                'role_id' => 'required',
                'name' => 'required',
                'username' => [
                    'required',
                    'alpha_num',
                    Rule::unique('vendors', 'username')->where('vendor_info_id', $vendor->vendor_info_id)->ignore($id)
                ],
                'email' => 'nullable|sometimes|email',
            ];

            $messages = [
                'role_id.required' => 'Role field is required',
                'name.required' => 'Name field is required',
                'email.required' => 'Email field is required',
                'email.unique' => 'Email already exists',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            if (!$request->has('status')) {
                $input['status'] = 0;
            }
            $input['admin_id'] = Auth::guard('admin')->user()->id;

            $vendor->update($input);

            if ($vendor->role->name != 'admin') {
                if ($request->get('permissions')) {
                    $vendor->permissions()->sync($request->get('permissions'));
                }
            }else {
                $vendor->permissions()->sync([]);
            }

            $vendor->syncRoles([$input['role_id']]);

            Session::flash('success', 'The Vendor User has been updated');

            return redirect()->route('admin.vendor-users.index');
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

        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendors-delete'])) {

            if (Auth::user()->id == $id) {

                Session::flash('error', 'You cannot delete your own account');

                return redirect()->route('admin.vendors.index');
            } else {
                $vendor = Vendor::find($id);
                $vendor->update([
                    'admin_id' => Auth::guard('admin')->user()->id,
                ]);
                $vendor->delete();

                Session::flash('success', 'The Vendor has been deleted');

                return redirect()->route('admin.vendor-users.index');
            }
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
    public function resetPassword($id)
    {

        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendors-update'])) {
            $vendor = Vendor::find($id);
            return view('admin.vendor-users.resetPassword', compact('vendor'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function resetPasswordStore($id, Request $request)
    {

        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendors-update'])) {

            $messages = [
                'password.required' => 'Password field is required',
                'password_confirmation.required' => 'Confirm Password field is required',
            ];

            $this->validate($request, [
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ], $messages);

            $input = $request->only('password');
            $input['password'] = bcrypt($request->get('password'));
            $input['admin_id'] = Auth::guard('admin')->user()->id;
            $vendor = Vendor::find($id);
            $vendor->update($input);

            Session::flash('success', 'Vendor User password has been updated');
            return redirect()->route('admin.vendor-users.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

}
