<?php

namespace App\Http\Controllers\admin;

use App\Client;
use App\User;
use App\Role;
use App\Unit;
use App\OfficeLocation;
use App\Designation;
use App\Department;
use App\Division;
use App\ClientCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ClientUserController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-users-read'])) {

            $roles = [];
            $companies = [];
            $departments = [];
            $designations = [];
            $divisions = [];
            $units = [];
            $locations = [];

            $users = User::where('id', '>', 0);
            if ($request->client_id) {
                $users->where('client_id', $request->client_id);

                $roles = Role::where([['type', 2], ['user_id', $request->client_id]])->pluck('display_name', 'id')->all();

                $companies = ClientCompany::where([['client_id', $request->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
                $departments = Department::where([['client_id', $request->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
                $designations = Designation::where([['client_id', $request->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
                $divisions = Division::where([['client_id', $request->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
                $units = Unit::where([['client_id', $request->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
                $locations = OfficeLocation::where([['client_id', $request->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            }

            if ($request->company) {
                $users->where('company_id', $request->company);
            }

            if ($request->workflow) {
                $users->where('workflow_id', $request->workflow);
            }

            if ($request->division) {
                $users->where('division_id', $request->division);
            }

            if ($request->department) {
                $users->where('department_id', $request->department);
            }

            if ($request->unit) {
                $users->where('unit_id', $request->unit);
            }

            if ($request->role_id) {
                $users->where('role_id', $request->role_id);
            }

            if ($request->location) {
                $users->where('office_location_id', $request->location);
            }

            if ($request->get('name')) {
                $users->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('email')) {
                $users->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }

            if ($request->get('phone')) {
                $users->where('phone', 'LIKE', '%' . $request->get('phone') . '%');
            }

            $users = $users->with('client', 'role', 'company', 'department', 'designation', 'division', 'unit', 'officelocation')->orderBy('name', 'ASC')->paginate(50);

            $clients = Client::where('status', 1)->orderBy('created_at', 'DESC')->pluck('name', 'id')->all();

            return view('admin.client-users.index', compact('users', 'companies', 'departments', 'designations', 'divisions', 'units', 'locations', 'roles', 'clients'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function create() {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-users-create'])) {
            $clients = Client::where('status', 1)->orderBy('created_at', 'DESC')->pluck('name', 'id')->all();
            $roles = [];

            if (old('client_id')) {
                $roles = Role::where([['type', 2], ['user_id', old('client_id')]])->pluck('display_name', 'id')->all();
            }
            return view('admin.client-users.create', compact('clients', 'roles'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-users-create'])) {

            $messages = [
                'client_id.required' => 'Client field is required',
                'role_id.required' => 'Role field is required',
                'name.required' => 'Name field is required',
                'email.required' => 'Email field is required',
                'email.unique' => 'Email already exists',
                'password.required' => 'Password field is required',
                'password_confirmation.required' => 'Confirm Password field is required',
            ];

            $this->validate($request, [
                'client_id' => 'required',
                'role_id' => 'required',
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('users', 'email')->where('client_id', $request->client_id)->whereNull('deleted_at'),
                    'email'
                ],
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
                    ], $messages);

            $input = $request->all();

            unset($input['password_confirmation']);

            $input['password'] = bcrypt($request->get('password'));
            $input['admin_id'] = Auth::guard('admin')->user()->id;
            $user = User::create($input);
            $user->attachRole($input['role_id']);

            Session::flash('success', 'The Client User has been created');

            return redirect()->route('admin.client-users.index');
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
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-users-update'])) {
            $user = User::find($id);
            $roles = Role::where([['type', 2], ['user_id', $user->client_id]])->pluck('display_name', 'id')->all();
            return view('admin.client-users.edit', compact('user', 'roles'));
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

        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-users-update'])) {
            $user = User::find($id);

            $rules = [
                'role_id' => 'required',
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('users', 'email')->where('client_id', $user->client_id)->whereNull('deleted_at')->ignore($id),
                    'email'
                ],
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


            $user->update($input);

            $user->syncRoles([$input['role_id']]);

            Session::flash('success', 'The Client User has been updated');

            return redirect()->route('admin.client-users.index');
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

        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-users-delete'])) {

            $user = User::find($id);
            $user->update([
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $user->delete();

            Session::flash('success', 'The Client User has been deleted');

            return redirect()->route('admin.client-users.index');
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
    public function resetPassword($id) {

        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-users-update'])) {
            $user = User::find($id);
            return view('admin.client-users.resetPassword', compact('user'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function resetPasswordStore($id, Request $request) {

        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-users-update'])) {

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
            $user = User::find($id);
            $user->update($input);

            Session::flash('success', 'Client User password has been updated');
            return redirect()->route('admin.client-users.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }


}
