<?php

namespace App\Http\Controllers\client;

use App\AssetCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AssetCategoryController extends Controller {

    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-categories-read'])) {

            $assetcategories = AssetCategory::where(function($query) {
                        $query->where('public', 1)->orWhere('client_id', Auth::user()->client_id);
                    });

            if ($request->get('title')) {
                $assetcategories->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            if ($request->has('type')) {
                if ($request->get('type') <> 2) {
                    $assetcategories->where('public', $request->get('type'));
                }
            }

            $assetcategories = $assetcategories->orderBy('title', 'ASC')->paginate(50);

            return view('client.asset-categories.index', compact('assetcategories', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-categories-create'])) {
            return view('client.asset-categories.create', compact('subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-categories-create'])) {
            $messages = [
                    //
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('asset_categories')->whereNull('deleted_at'),
                ],
                    ], $messages);

            $input = $request->all();

            $input['client_id'] = Auth::user()->client_id;
            $input['user_id'] = Auth::user()->id;

            AssetCategory::create($input);

            Session::flash('success', 'The Asset Category has been created');

            return redirect()->route('client.asset-categories.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-categories-update'])) {
            $assetcategory = AssetCategory::find($id);
            return view('client.asset-categories.edit', compact('assetcategory', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-categories-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('asset_categories')->whereNull('deleted_at')->ignore($id),
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

            $assetcategory = AssetCategory::find($id);
            $assetcategory->update($input);

            Session::flash('success', 'The Asset Category has been updated');

            return redirect()->route('client.asset-categories.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-categories-delete'])) {
            $assetcategory = AssetCategory::find($id);

            $assetcategory->update([
                'user_id' => Auth::user()->id,
            ]);

            $assetcategory->delete();

            Session::flash('success', 'The Asset Category has been deleted');

            return redirect()->route('client.asset-categories.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
