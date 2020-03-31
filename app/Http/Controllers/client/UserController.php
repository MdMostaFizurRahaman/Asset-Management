<?php

namespace App\Http\Controllers\client;

use App\Asset;
use App\AssetAssignLog;
use App\User;
use App\Role;
use App\ClientCompany;
use App\Department;
use App\Designation;
use App\Unit;
use App\Division;
use App\OfficeLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-users-read'])) {
            $users = User::where('client_id', Auth::user()->client_id);

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

            if ($request->role) {
                $users->where('role_id', $request->role);
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

            if ($request->unit) {
                $users->where('unit_id', $request->unit);
            }

            $users = $users->with('role', 'company', 'department', 'designation', 'division', 'unit', 'officelocation')->orderBy('created_at', 'DESC')->paginate(50);

            $companies = ClientCompany::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $departments = Department::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $designations = Designation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $divisions = Division::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $units = Unit::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $locations = OfficeLocation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $roles = Role::where([['type', 2], ['user_id', Auth::user()->client_id]])->orderBy('display_name', 'ASC')->pluck('display_name', 'id')->all();

            return view('client.users.index', compact('users', 'subdomain', 'companies', 'departments', 'designations', 'divisions', 'units', 'locations', 'roles'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-users-create'])) {
            $roles = Role::where([['type', 2], ['user_id', Auth::user()->client_id]])->orderBy('display_name', 'ASC')->pluck('display_name', 'id')->all();
            $companies = ClientCompany::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $departments = Department::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $designations = Designation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $divisions = Division::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $units = Unit::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $locations = OfficeLocation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('client.users.create', compact('roles', 'subdomain', 'companies', 'departments', 'designations', 'divisions', 'units', 'locations'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store(Request $request, $subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-users-create'])) {

            $user = Auth::user();
            $messages = [
                'company_id.required' => 'Please select a company',
                'division_id.required' => 'Please select a division',
                'department_id.required' => 'Please select a department',
                'unit_id.required' => 'Please select a unit',
                'office_location_id.required' => 'Please select a office location',
                'designation_id.required' => 'Please select a designation',
                'name.required' => 'Name field is required',
                'email.required' => 'Email field is required',
                'email.unique' => 'Email already exists',
                'password.required' => 'Password field is required',
                'password_confirmation.required' => 'Confirm Password field is required',
                'role_id.required' => 'Please select a role',
            ];

            $this->validate($request, [
                'company_id' => 'required',
                'division_id' => 'required',
                'department_id' => 'required',
                'unit_id' => 'required',
                'office_location_id' => 'required',
                'designation_id' => 'required',
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('users', 'email')->where('client_id', $user->client_id)->whereNull('deleted_at'),
                    'email'
                ],
                'phone' => [
                    'required',
                    'regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/'
                ],
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
                'role_id' => 'required',
            ], $messages);

            $input = $request->all();

            unset($input['password_confirmation']);

            $input['password'] = bcrypt($request->get('password'));
            $input['user_id'] = $user->id;
            $input['client_id'] = $user->client_id;
            $user = User::create($input);
            $user->attachRole($input['role_id']);

            Session::flash('success', 'The User has been created');

            return redirect()->route('client.users.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain, $id)
    {

        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-users-read'])) {

            $user = User::findOrFail($id);
            return view('client.users.show', compact('user', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-users-update'])) {
            $user = User::find($id);
            $roles = Role::where([['type', 2], ['user_id', Auth::user()->client_id]])->orderBy('display_name', 'ASC')->pluck('display_name', 'id')->all();
            $companies = ClientCompany::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $departments = Department::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $designations = Designation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $divisions = Division::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $units = Unit::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $locations = OfficeLocation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('client.users.edit', compact('user', 'roles', 'subdomain', 'companies', 'departments', 'designations', 'divisions', 'units', 'locations'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subdomain, $id)
    {

        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-users-update'])) {
            $user = Auth::user();
            $rules = [
                'company_id' => 'required',
                'division_id' => 'required',
                'department_id' => 'required',
                'unit_id' => 'required',
                'office_location_id' => 'required',
                'designation_id' => 'required',
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('users', 'email')->where('client_id', $user->client_id)->whereNull('deleted_at')->ignore($id),
                    'email'
                ],
                'phone' => [
                    'required',
                    'regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/'
                ],
                'role_id' => 'required',
            ];

            $messages = [
                'company_id.required' => 'Please select a company',
                'division_id.required' => 'Please select a division',
                'department_id.required' => 'Please select a department',
                'unit_id.required' => 'Please select a unit',
                'office_location_id.required' => 'Please select a office location',
                'designation_id.required' => 'Please select a designation',
                'name.required' => 'Name field is required',
                'email.required' => 'Email field is required',
                'email.unique' => 'Email already exists',
                'password.required' => 'Password field is required',
                'password_confirmation.required' => 'Confirm Password field is required',
                'role_id.required' => 'Please select a role',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $input['user_id'] = $user->id;

            $user = User::find($id);
            $user->update($input);

            $user->syncRoles([$input['role_id']]);

            Session::flash('success', 'The User has been updated');

            return redirect()->route('client.users.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, $id)
    {

        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-users-delete'])) {
            if (Auth::user()->id == $id) {

                Session::flash('error', 'You cannot delete your own account');

                return redirect()->route('client.users.index', $subdomain);
            } else {
                $user = User::find($id);
                $user->update([
                    'user_id' => Auth::user()->id,
                ]);
                $user->delete();

                Session::flash('success', 'The User has been deleted');

                return redirect()->route('client.users.index', $subdomain);
            }
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function resetPassword($subdomain, $id)
    {

        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-users-update'])) {
            $user = User::find($id);
            return view('client.users.resetPassword', compact('user', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function resetPasswordStore($subdomain, $id, Request $request)
    {

        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-users-update'])) {

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
            $input['user_id'] = Auth::user()->id;
            $user = User::find($id);
            $user->update($input);

            Session::flash('success', 'User password has been updated');
            return redirect()->route('client.users.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
