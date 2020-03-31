<?php

namespace App\Http\Controllers\vendor;

use App\VendorInfo;
use App\VendorPermissionCategory;
use Auth;
use App\Role;
use App\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class VendorUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:vendor');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-users-read')) {

            $vendors = Vendor::whereIn('vendor_info_id', [Auth::guard('vendor')->user()->vendor_info_id])->orderBy('name', 'ASC');

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

            $roles = Role::where('user_id',Auth::guard('vendor')->user()->vendor_info_id)->where('type', 3)->pluck('display_name', 'id')->all();

            return view('vendor.vendor-users.index', compact('vendors', 'roles'));
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
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-users-create'])) {
            $categories = VendorPermissionCategory::where('status', 1)->with('permissions')->get();
            $roles = Role::where(['user_id' => Auth::guard('vendor')->user()->vendor_info_id, 'type' => 3])->pluck('display_name', 'id')->all();
            return view('vendor.vendor-users.create', compact('categories', 'roles'));
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
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-users-create'])) {

            $messages = [
                'role_id.required' => 'Role field is required.',
                'name.required' => 'Name field is required.',
                'username.required' => 'User Id field is required.',
                'username.unique' => 'You can\'t use this User Id.',
                'username.alpha_num' => 'User Id may only contain letters and numbers.',
                'password.required' => 'Password field is required.',
                'password_confirmation.required' => 'Confirm Password field is required.',
            ];

            $this->validate($request, [
                'role_id' => 'required',
                'name' => 'required',
                'username' => [
                    'required',
                    'alpha_num',
                    Rule::unique('vendors', 'username')->where('vendor_info_id', Auth::guard('vendor')->user()->vendor_info_id)
                ],
                'email' => 'nullable|sometimes|email',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ], $messages);

            $input = $request->all();

            unset($input['password_confirmation']);

            $input['password'] = bcrypt($request->get('password'));
            $input['admin_id'] = Auth::guard('vendor')->user()->id;
            $input['api_token'] = time() . str_random(30) . date("Ymd") . uniqid() . str_random(30);
            $input['vendor_info_id'] = Auth::guard('vendor')->user()->vendor_info_id;
//            dd($input);
            $vendor = Vendor::create($input);

            if ($vendor->role->name != 'admin') {
                if ($request->get('permissions')) {
                    $vendor->permissions()->sync($request->get('permissions'));
                }
            }

            $vendor->attachRole($input['role_id']);

            Session::flash('success', 'The Vendor has been created');

            return redirect()->route('vendor.vendors.index');
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
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-users-update'])) {
            $vendor = Vendor::findOrFail($id);
            $categories = VendorPermissionCategory::where('status', 1)->with('permissions')->get();
            $roles = Role::where(['user_id' => Auth::guard('vendor')->user()->vendor_info_id, 'type' => 3])->pluck('display_name', 'id')->all();
            return view('vendor.vendor-users.edit', compact('vendor', 'categories', 'roles'));
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
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-users-update'])) {
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
                'role_id.required' => 'Role field is required.',
                'name.required' => 'Name field is required.',
                'username.required' => 'User Id field is required.',
                'username.unique' => 'You can\'t use this User Id.',
                'username.alpha_num' => 'User Id may only contain letters and numbers.',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            if (!$request->has('status')) {
                $input['status'] = 0;
            }
            $input['admin_id'] = Auth::guard('vendor')->user()->id;

            $vendor->update($input);

            if ($vendor->role->name != 'admin') {
                if ($request->get('permissions')) {
                    $vendor->permissions()->sync($request->get('permissions'));
                }
            }else {
                $vendor->permissions()->sync([]);
            }

            $vendor->syncRoles([$input['role_id']]);

            Session::flash('success', 'The Vendor has been updated');

            return redirect()->route('vendor.vendors.index');
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
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-users-delete'])) {

            if (Auth::guard('vendor')->user()->id == $id) {

                Session::flash('error', 'You cannot delete your own account');

                return redirect()->route('vendor.vendors.index');
            } else {
                $vendor = Vendor::findOrFail($id);
                $vendor->update([
                    'admin_id' => Auth::guard('vendor')->user()->id,
                ]);
                $vendor->delete();

                Session::flash('success', 'The Vendor has been deleted');

                return redirect()->route('vendor.vendors.index');
            }
        } else {
            return view('error.vendor-unauthorised');
        }
    }

    //User Password Reset
    public function resetPassword($id)
    {
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-users-update'])) {
            $vendor = Vendor::findOrFail($id);
            return view('vendor.vendor-users.resetPassword', compact('vendor'));
        } else {
            return view('error.vendor-unauthorised');
        }
    }

    //Update Password
    public function resetPasswordStore($id, Request $request)
    {

        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-users-update'])) {

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
            $input['admin_id'] = Auth::guard('vendor')->user()->id;
            $vendor = Vendor::findOrFail($id);
            $vendor->update($input);

            Session::flash('success', 'Vendor User password has been updated');
            return redirect()->route('vendor.vendors.index');
        } else {
            return view('error.vendor-unauthorised');
        }
    }
}
