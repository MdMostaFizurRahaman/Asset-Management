<?php

namespace App\Http\Controllers\admin;

use App\AssetCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AssetCategoryController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-categories-read'])) {

            $assetcategories = AssetCategory::where('id', '>', 0);

            if ($request->get('title')) {
                $assetcategories->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            if ($request->has('type')) {
                if ($request->get('type') <> 2) {
                    $assetcategories->where('public', $request->get('type'));
                }
            }

            $assetcategories = $assetcategories->orderBy('title', 'ASC')->paginate(50);
            return view('admin.asset-categories.index', compact('assetcategories'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function create() {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-categories-create'])) {
            return view('admin.asset-categories.create');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-categories-create'])) {
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

            $input['admin_id'] = Auth::guard('admin')->user()->id;
            $input['public'] = 1;

            AssetCategory::create($input);

            Session::flash('success', 'The Asset Category has been created');

            return redirect()->route('admin.asset-categories.index');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-categories-update'])) {
            $assetcategory = AssetCategory::find($id);
            return view('admin.asset-categories.edit', compact('assetcategory'));
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-categories-update'])) {
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
            $input['admin_id'] = Auth::guard('admin')->user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $assetcategory = AssetCategory::find($id);
            $assetcategory->update($input);

            Session::flash('success', 'The Asset Category has been updated');

            return redirect()->route('admin.asset-categories.index');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-categories-delete'])) {
            $assetcategory = AssetCategory::find($id);

            $assetcategory->update([
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $assetcategory->delete();

            Session::flash('success', 'The Asset Category has been deleted');

            return redirect()->route('admin.asset-categories.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function pending(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-categories-pending'])) {

            $assetcategories = AssetCategory::where([['public', 0], ['user_id', '<>', 0]]);

            if ($request->get('title')) {
                $assetcategories->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            $assetcategories = $assetcategories->orderBy('title', 'ASC')->paginate(50);

            return view('admin.asset-categories.pending', compact('assetcategories'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function approved($id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-categories-approved'])) {
            $assetcategory = AssetCategory::find($id);

            $assetcategory->update([
                'admin_id' => Auth::guard('admin')->user()->id,
                'public' => 1,
            ]);
            Session::flash('success', 'The Asset Category has been made public');

            return redirect()->route('admin.asset-categories.pending');
        } else {
            return view('error.admin-unauthorised');
        }
    }

}
