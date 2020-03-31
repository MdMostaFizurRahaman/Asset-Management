<?php

namespace App\Http\Controllers\client;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller {

    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-departments-read'])) {

            $departments = Department::where('client_id', Auth::user()->client_id);

            if ($request->get('title')) {
                $departments->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            $departments = $departments->orderBy('title', 'ASC')->paginate(50);

            return view('client.departments.index', compact('departments', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-departments-create'])) {
            return view('client.departments.create', compact('subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-departments-create'])) {
            $messages = [
                'title.required' => 'Department Title is required.',
                'title.unique' => 'Department Title already exist.',
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('departments')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                ],
                    ], $messages);

            $input = $request->all();

            $input['user_id'] = Auth::user()->id;
            $input['client_id'] = Auth::user()->client_id;

            Department::create($input);

            Session::flash('success', 'The Department has been created');

            return redirect()->route('client.departments.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, $id) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-departments-update'])) {
            $department = Department::find($id);
            return view('client.departments.edit', compact('department', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, Request $request, $id) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-departments-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('departments')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($id),
                ],
            ];

            $messages = [
                'title.required' => 'Department Title is required.',
                'title.unique' => 'Department Title already exist.',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $department = Department::find($id);
            $department->update($input);

            Session::flash('success', 'The Department has been updated');

            return redirect()->route('client.departments.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, $id) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-departments-delete'])) {
            $department = Department::find($id);

            $department->update([
                'user_id' => Auth::user()->id,
            ]);

            $department->delete();

            Session::flash('success', 'The Department has been deleted');

            return redirect()->route('client.departments.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
