<?php

namespace App\Http\Controllers\client;

use App\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller {

    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-designations-read'])) {

            $designations = Designation::where('client_id', Auth::user()->client_id);

            if ($request->get('title')) {
                $designations->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            $designations = $designations->orderBy('title', 'ASC')->paginate(50);

            return view('client.designations.index', compact('designations', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-designations-create'])) {
            return view('client.designations.create', compact('subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-designations-create'])) {
            $messages = [
                'title.required' => 'Designation Title is required.',
                'title.unique' => 'Designation Title already exist.',
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('designations')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                ],
                    ], $messages);

            $input = $request->all();

            $input['user_id'] = Auth::user()->id;
            $input['client_id'] = Auth::user()->client_id;

            Designation::create($input);

            Session::flash('success', 'The Designation has been created');

            return redirect()->route('client.designations.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-designations-update'])) {
            $designation = Designation::find($id);
            return view('client.designations.edit', compact('designation', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-designations-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('designations')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($id),
                ],
            ];

            $messages = [
                'title.required' => 'Designation Title is required.',
                'title.unique' => 'Designation Title already exist.',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $designation = Designation::find($id);
            $designation->update($input);

            Session::flash('success', 'The Designation has been updated');

            return redirect()->route('client.designations.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-designations-delete'])) {
            $designation = Designation::find($id);

            $designation->update([
                'user_id' => Auth::user()->id,
            ]);

            $designation->delete();

            Session::flash('success', 'The Designation has been deleted');

            return redirect()->route('client.designations.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
