<?php

namespace App\Http\Controllers\admin;

use App\Client;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-clients-read'])) {

            $clients = Client::orderBy('name', 'ASC');
            //for searching--
            if ($request->get('name')) {
                $clients->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('email')) {
                $clients->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }

            if ($request->get('phone')) {
                $clients->where('phone', 'LIKE', '%' . $request->get('phone') . '%');
            }

            $clients = $clients->paginate(50);

            return view('admin.clients.index', compact('clients'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function create()
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-clients-create'])) {
            return view('admin.clients.create');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function store(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-clients-create'])) {

            $messages = [
                'name.required' => 'Name field is required',
                'email.required' => 'Email field is required',
                'email.unique' => 'Email already exists',
            ];

            $this->validate($request, [
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('clients', 'email')->whereNull('deleted_at'),
                    'email'
                ],
                'secondary_email' => 'sometimes|nullable|email',
                'phone' => [
                    'required',
                    'regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                ],
                'client_url' => [
                    'required',
                    'regex:/^[\w-]*$/',
                    Rule::unique('clients', 'client_url')->whereNull('deleted_at'),
                ],
                'contact_person_name' => 'required',
                'contact_person_phone' => 'required',
                'contact_person_email' => 'required|email',
                'address' => 'required',
            ], $messages);

            $input = $request->all();

            $input['admin_id'] = Auth::guard('admin')->user()->id;
            $client = Client::create($input);

            Role::create([
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Admin Role for ' . $client->name . " Client",
                'user_id' => $client->id,
                'type' => 2,
            ]);

            Session::flash('success', 'The Client has been created');

            return redirect()->route('admin.clients.index');
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
    public function show($id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-clients-read'])) {
            $client = Client::find($id);
            return view('admin.clients.show', compact('client'));
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-clients-update'])) {
            $client = Client::find($id);
            return view('admin.clients.edit', compact('client'));
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

        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-clients-update'])) {

            $rules = [
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('clients', 'email')->whereNull('deleted_at')->ignore($id),
                    'email'
                ],
                'secondary_email' => 'sometimes|nullable|email',
                'phone' => [
                    'required',
                    'regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                ],
                'client_url' => [
                    'required',
                    'regex:/^[\w-]*$/',
                    Rule::unique('clients', 'client_url')->whereNull('deleted_at')->ignore($id),
                ],
                'contact_person_name' => 'required',
                'contact_person_phone' => 'required',
                'contact_person_email' => 'required|email',
                'address' => 'required',
            ];

            $messages = [
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

            $client = Client::find($id);
            $client->update($input);

            Session::flash('success', 'The Client has been updated');

            return redirect()->route('admin.clients.index');
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

        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-clients-delete'])) {

            $client = Client::find($id);
            $client->update([
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $client->delete();

            Session::flash('success', 'The Client has been deleted');

            return redirect()->route('admin.clients.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }
}
