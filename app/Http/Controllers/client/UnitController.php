<?php

namespace App\Http\Controllers\client;

use App\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller {

    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-units-read'])) {

            $units = Unit::where('client_id', Auth::user()->client_id);

            if ($request->get('title')) {
                $units->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            $units = $units->orderBy('title', 'ASC')->paginate(50);

            return view('client.units.index', compact('units', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-units-create'])) {
            return view('client.units.create', compact('subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-units-create'])) {
            $messages = [
                'title.required' => 'Unit Title is required.',
                'title.unique' => 'Unit Title already exist.',
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('units')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                ],
                    ], $messages);

            $input = $request->all();

            $input['user_id'] = Auth::user()->id;
            $input['client_id'] = Auth::user()->client_id;

            Unit::create($input);

            Session::flash('success', 'The Unit has been created');

            return redirect()->route('client.units.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-units-update'])) {
            $unit = Unit::find($id);
            return view('client.units.edit', compact('unit', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-units-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('units')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($id),
                ],
            ];

            $messages = [
                'title.required' => 'Unit Title is required.',
                'title.unique' => 'Unit Title already exist.',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $unit = Unit::find($id);
            $unit->update($input);

            Session::flash('success', 'The Unit has been updated');

            return redirect()->route('client.units.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-units-delete'])) {
            $unit = Unit::find($id);

            $unit->update([
                'user_id' => Auth::user()->id,
            ]);

            $unit->delete();

            Session::flash('success', 'The Unit has been deleted');

            return redirect()->route('client.units.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
