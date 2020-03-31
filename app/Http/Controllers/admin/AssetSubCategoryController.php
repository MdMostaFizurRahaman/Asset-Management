<?php

namespace App\Http\Controllers\admin;

use App\AssetSubCategory;
use App\AssetCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AssetSubCategoryController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-subcategories-read')) {

            $assetsubcategories = AssetSubCategory::where('id', '>', 0);

            if ($request->get('title')) {
                $assetsubcategories->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            if ($request->has('type')) {
                if ($request->get('type') <> 2) {
                    $assetsubcategories->where('public', $request->get('type'));
                }
            }

            if ($request->get('category')) {
                $assetsubcategories->where('category_id', $request->get('category'));
            }

            $assetsubcategories = $assetsubcategories->orderBy('title', 'ASC')->with('category')->paginate(50);
            $categories = AssetCategory::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();

            return view('admin.asset-subcategories.index', compact('assetsubcategories', 'categories'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function create() {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-subcategories-create')) {
            $categories = AssetCategory::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('admin.asset-subcategories.create', compact('categories'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-subcategories-create')) {
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

            $input['admin_id'] = Auth::guard('admin')->user()->id;
            $input['public'] = 1;

            AssetSubCategory::create($input);

            Session::flash('success', 'The Asset SubCategory has been created');

            return redirect()->route('admin.asset-subcategories.index');
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
    public function edit($id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-subcategories-update')) {
            $assetsubcategory = AssetSubCategory::find($id);
            $categories = AssetCategory::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('admin.asset-subcategories.edit', compact('assetsubcategory', 'categories'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-subcategories-update')) {
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
            $input['admin_id'] = Auth::guard('admin')->user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $assetsubcategory = AssetSubCategory::find($id);
            $assetsubcategory->update($input);

            Session::flash('success', 'The Asset SubCategory has been updated');

            return redirect()->route('admin.asset-subcategories.index');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-subcategories-delete')) {
            $assetsubcategory = AssetSubCategory::find($id);

            $assetsubcategory->update([
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $assetsubcategory->delete();

            Session::flash('success', 'The Asset SubCategory has been deleted');

            return redirect()->route('admin.asset-subcategories.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function pending(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-subcategories-pending'])) {
            $assetsubcategories = AssetSubCategory::where([['public', 0], ['user_id', '<>', 0]]);

            if ($request->get('title')) {
                $assetsubcategories->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            if ($request->get('category')) {
                $assetsubcategories->where('category_id', $request->get('category'));
            }

            $assetsubcategories = $assetsubcategories->orderBy('title', 'ASC')->with('category')->paginate(50);

            $categories = AssetCategory::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('admin.asset-subcategories.pending', compact('assetsubcategories', 'categories'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function approved($id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-categories-approved'])) {
            $assetsubcategory = AssetSubCategory::find($id);

            $assetsubcategory->update([
                'admin_id' => Auth::guard('admin')->user()->id,
                'public' => 1,
            ]);
            Session::flash('success', 'The Asset SubCategory has been made public');

            return redirect()->route('admin.asset-subcategories.pending');
        } else {
            return view('error.admin-unauthorised');
        }
    }

}
