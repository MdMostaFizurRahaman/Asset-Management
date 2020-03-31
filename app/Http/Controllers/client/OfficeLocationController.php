<?php

namespace App\Http\Controllers\client;

use App\OfficeLocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class OfficeLocationController extends Controller {

    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-office-locations-read'])) {

            $locations = OfficeLocation::where('client_id', Auth::user()->client_id);

            if ($request->get('title')) {
                $locations->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            $locations = $locations->orderBy('title', 'ASC')->paginate(50);

            return view('client.office-locations.index', compact('locations', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-office-locations-create'])) {
            return view('client.office-locations.create', compact('subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-office-locations-create'])) {
            $messages = [
                'title.required' => 'Office Location Title is required.',
                'title.unique' => 'Office Location Title already exist.',
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('office_locations')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                ],
                    ], $messages);

            $input = $request->all();

            $input['user_id'] = Auth::user()->id;
            $input['client_id'] = Auth::user()->client_id;

            OfficeLocation::create($input);

            Session::flash('success', 'The Office Location has been created');

            return redirect()->route('client.office-locations.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-office-locations-update'])) {
            $location = OfficeLocation::find($id);
            return view('client.office-locations.edit', compact('location', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-office-locations-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('office_locations')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($id),
                ],
            ];

            $messages = [
                'title.required' => 'Office Location Title is required.',
                'title.unique' => 'Office Location Title already exist.',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $location = OfficeLocation::find($id);
            $location->update($input);

            Session::flash('success', 'The Office Location has been updated');

            return redirect()->route('client.office-locations.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-office-locations-delete'])) {
            $location = OfficeLocation::find($id);

            $location->update([
                'user_id' => Auth::user()->id,
            ]);

            $location->delete();

            Session::flash('success', 'The Office Location has been deleted');

            return redirect()->route('client.office-locations.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
