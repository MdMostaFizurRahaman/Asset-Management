<?php

namespace App\Http\Controllers\client;

use App\AssetTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AssetTagController extends Controller {

    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-tags-read'])) {

            $assettags = AssetTag::where('client_id', Auth::user()->client_id);

            if ($request->get('title')) {
                $assettags->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            $assettags = $assettags->orderBy('title', 'ASC')->paginate(50);

            return view('client.asset-tags.index', compact('assettags', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-tags-create'])) {
            return view('client.asset-tags.create', compact('subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-tags-create'])) {
            $messages = [
                    //
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('asset_tags')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                ],
                    ], $messages);

            $input = $request->all();

            $input['user_id'] = Auth::user()->id;
            $input['client_id'] = Auth::user()->client_id;

            AssetTag::create($input);

            Session::flash('success', 'The Asset Tag has been created');

            return redirect()->route('client.asset-tags.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-tags-update'])) {
            $assettag = AssetTag::find($id);
            return view('client.asset-tags.edit', compact('assettag', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-tags-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('asset_tags')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($id),
                ],
            ];

            $messages = [
                    //
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $assettag = AssetTag::find($id);
            $assettag->update($input);

            Session::flash('success', 'The Asset Tag has been updated');

            return redirect()->route('client.asset-tags.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-tags-delete'])) {
            $assettag = AssetTag::find($id);

            $assettag->update([
                'user_id' => Auth::user()->id,
            ]);

            $assettag->delete();

            Session::flash('success', 'The Asset Tag has been deleted');

            return redirect()->route('client.asset-tags.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
