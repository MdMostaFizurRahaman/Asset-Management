<?php

namespace App\Http\Controllers\admin;

use App\Client;
use App\Role;
use App\ClientPermissionCategory;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

class ClientRoleController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index($id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-roles-read'])) {
            $client = Client::find($id);
            $categories = ClientPermissionCategory::where('status', 1)->orderBy('name', 'ASC')->with('permissions')->get();
            return view('admin.client-roles.index', compact('client', 'categories'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function create() {
        //
    }

    public function store($id, Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-roles-create'])) {

            $rules = [
                'display_name' => [
                    'required',
                    Rule::unique('roles')->where('user_id', $id)->where('type', 2),
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

            $input['name'] = strtolower('client-' . Helper::urlSlug($input['display_name']));
            $input['user_id'] = $id;
            $input['type'] = 2;

            $role = Role::create($input);

            if ($request->get('permissions')) {
                $role->permissions()->sync($request->get('permissions'));
            }

            Session::flash('success', 'The Role has been created');

            return redirect()->route('admin.client-roles.index', $id);
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
    public function edit($client, $id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-roles-update'])) {
            $role = Role::find($id);
            $categories = ClientPermissionCategory::where('status', 1)->orderBy('name', 'ASC')->with('permissions')->get();
            return view('admin.client-roles.edit', compact('role', 'categories'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $client
     * @param $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $client, $id) {

        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-roles-update'])) {

            if($id == 1) {
                $rules = [
                    'display_name' => [
                        'required',
                        Rule::unique('roles')->ignore($id),
                    ],
                    'description' => 'required',
                ];
            } else {
                $rules = [
                    'display_name' => [
                        'required',
                        Rule::unique('roles')->where('user_id', $client)->where('type', 2)->ignore($id),
                    ],
                    'description' => 'required',
                    'permissions' => 'required',
                ];
            }

            $messages = [
                'display_name.required' => 'Name field is required',
                'display_name.unique' => 'Name field is already exists',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $role = Role::find($id);

            if($role->name <> 'admin') {
                $input['name'] = strtolower('client-' . Helper::urlSlug($input['display_name']));
            }

            $role->update($input);

            if ($request->get('permissions')) {
                $role->permissions()->sync($request->get('permissions'));
            } else {
                $role->permissions()->sync([]);
            }

            Session::flash('success', 'The Role has been updated');

            return redirect()->route('admin.client-roles.index', $client);
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

        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-roles-delete'])) {

            $role = Role::find($id);
            // Role existence check in User model
            $user_assigned_role = User::pluck('role_id', 'role_id')->all();
            if (in_array($id, $user_assigned_role)) {
                Session::flash('warning', 'This Role already assigned an user');
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
