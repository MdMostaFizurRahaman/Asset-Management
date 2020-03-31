<?php

namespace App\Http\Controllers\client;

use App\AssetSubCategory;
use App\AssetCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AssetSubCategoryController extends Controller {

    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-subcategories-read')) {

            $assetsubcategories = AssetSubCategory::where(function($query){
                $query->where('client_id', Auth::user()->client_id)->orWhere('public', 1);
            });

            if ($request->get('title')) {
                $assetsubcategories->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            if ($request->get('category')) {
                $assetsubcategories->where('category_id', $request->get('category'));
            }

            if ($request->has('type')) {
                if ($request->get('type') <> 2) {
                    $assetsubcategories->where('public', $request->get('type'));
                }
            }

            $assetsubcategories = $assetsubcategories->with('category')->orderBy('title', 'ASC')->paginate(50);

            $categories = AssetCategory::where(function($query) {
                $query->where('public', 1)->orWhere('client_id', Auth::user()->client_id);
            })->orderBy('title', 'ASC')->pluck('title', 'id')->all();

            return view('client.asset-subcategories.index', compact('assetsubcategories', 'subdomain', 'categories'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-subcategories-create')) {
            $categories = AssetCategory::where('status', 1)->where('public', 1)->orWhere('client_id', Auth::user()->client_id)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('client.asset-subcategories.create', compact('categories', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-subcategories-create')) {
            $messages = [
                'category_id.required' => 'Please select a category.',
            ];

            $this->validate($request, [
                'category_id' => 'required',
                'title' => [
                    'required',
                    Rule::unique('asset_sub_categories')->where('category_id', $request->category_id)->whereNull('deleted_at'),
                ],
            ], $messages);

            $input = $request->all();

            $input['client_id'] = Auth::user()->client_id;
            $input['user_id'] = Auth::user()->id;

            AssetSubCategory::create($input);

            Session::flash('success', 'The Asset SubCategory has been created');

            return redirect()->route('client.asset-subcategories.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-subcategories-update')) {
            $assetsubcategory = AssetSubCategory::find($id);
            $categories = AssetCategory::where('status', 1)->where('public', 1)->orWhere('client_id', Auth::user()->client_id)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('client.asset-subcategories.edit', compact('assetsubcategory', 'categories', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-subcategories-update')) {
            $rules = [
                'category_id' => 'required',
                'title' => [
                    'required',
                    Rule::unique('asset_sub_categories')->where('category_id', $request->category_id)->whereNull('deleted_at')->ignore($id),
                ],
            ];

            $messages = [
                'category_id.required' => 'Please select a category.',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $assetsubcategory = AssetSubCategory::find($id);
            $assetsubcategory->update($input);

            Session::flash('success', 'The Asset SubCategory has been updated');

            return redirect()->route('client.asset-subcategories.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-subcategories-delete')) {
            $assetsubcategory = AssetSubCategory::find($id);

            $assetsubcategory->update([
                'user_id' => Auth::user()->id,
            ]);
            $assetsubcategory->delete();

            Session::flash('success', 'The Asset SubCategory has been deleted');

            return redirect()->route('client.asset-subcategories.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
