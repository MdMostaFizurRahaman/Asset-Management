<?php

namespace App\Http\Controllers\client;

use App\ClientPermissionCategory;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

class ClientRoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-client-roles-read'])) {
            $roles = Role::where('user_id', Auth::user()->client_id)->where('type', '2')->orderBy('created_at', 'DESC')->paginate(20);
            $user_assigned_role = User::pluck('role_id', 'role_id')->all();
            return view('client.client-roles.index', compact('roles', 'user_assigned_role', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-client-roles-create'])) {
            $categories = ClientPermissionCategory::where('status', 1)->with('permissions')->get();
            return view('client.client-roles.create', compact('subdomain', 'categories'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-client-roles-create'])) {

            $rules = [
                'display_name' => [
                    'required',
                    Rule::unique('roles')->where('user_id', Auth::user()->client_id)->where('type', '2'),
                ],
                'description' => 'required',
                'permissions' => 'required',
            ];

            $messages = [
                'display_name.required' => 'Name field is required',
                'display_name.unique' => 'Name is already exists',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();

            $input['name'] = strtolower('client-' . Helper::urlSlug($input['display_name']));
            $input['user_id'] = Auth::user()->client_id;
            $input['type'] = 2;

            $role = Role::create($input);

            if ($request->get('permissions')) {
                $role->permissions()->sync($request->get('permissions'));
            }

            Session::flash('success', 'The Role has been created');

            return redirect()->route('client.client-roles.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-client-roles-update'])) {
            $role = Role::find($id);
            $categories = ClientPermissionCategory::where('status', 1)->with('permissions')->get();
            return view('client.client-roles.edit', compact('role', 'subdomain', 'categories'));
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
    public function update($subdomain, Request $request, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-client-roles-update'])) {

            $rules = [
                'display_name' => [
                    'required',
                    Rule::unique('roles')->where('user_id', Auth::user()->client_id)->where('type', '2')->ignore($id),
                ],
                'description' => 'required',
                'permissions' => 'required',
            ];

            $messages = [
                'display_name.required' => 'Name field is required',
                'display_name.unique' => 'Name is already exists',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();

            $role = Role::find($id);

            if ($role->name <> 'admin') {
                $input['name'] = strtolower('client-' . Helper::urlSlug($input['display_name']));
            }
            $role->update($input);

            if ($request->get('permissions')) {
                $role->permissions()->sync($request->get('permissions'));
            } else {
                $role->permissions()->sync([]);
            }

            Session::flash('success', 'The Role has been updated');

            return redirect()->route('client.client-roles.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-client-roles-delete'])) {
            $role = Role::find($id);
            // Role existence check in User model
            $user_assigned_role = User::pluck('role_id', 'role_id')->all();
            if (in_array($id, $user_assigned_role)) {
                Session::flash('warning', 'This Role already assigned an user');
                return redirect()->route('client.client-roles.index', $subdomain);
            }

            $role->permissions()->sync([]);
            $role->delete();
            Session::flash('success', 'The Role has been deleted');

            return redirect()->route('client.client-roles.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
