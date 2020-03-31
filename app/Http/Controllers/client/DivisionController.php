<?php

namespace App\Http\Controllers\client;

use App\Division;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DivisionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-divisions-read'])) {
            $divisions = Division::where('client_id', Auth::user()->client_id);
            if ($request->get('title')) {
                $divisions->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }
            $divisions = $divisions->orderBy('title', 'ASC')->paginate(50);

            return view('client.divisions.index', compact('divisions', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-divisions-create'])) {
            return view('client.divisions.create', compact('subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-divisions-create'])) {
            $messages = [
                'title.required' => 'Division Title is required.',
                'title.unique' => 'Division Title already exist.',
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('divisions')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                ],
            ], $messages);

            $input = $request->all();

            $input['user_id'] = Auth::user()->id;
            $input['client_id'] = Auth::user()->client_id;

            Division::create($input);

            Session::flash('success', 'The Division has been created');

            return redirect()->route('client.divisions.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-divisions-update'])) {
            $division = Division::find($id);
            return view('client.divisions.edit', compact('division', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-divisions-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('divisions')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($id),
                ],
            ];

            $messages = [
                'title.required' => 'Division Title is required.',
                'title.unique' => 'Division Title already exist.',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $division = Division::find($id);
            $division->update($input);

            Session::flash('success', 'The Division has been updated');

            return redirect()->route('client.divisions.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-divisions-delete'])) {
            $division = Division::find($id);

            $division->update([
                'user_id' => Auth::user()->id,
            ]);

            $division->delete();

            Session::flash('success', 'The Division has been deleted');

            return redirect()->route('client.divisions.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
