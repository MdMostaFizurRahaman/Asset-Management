<?php

namespace App\Http\Controllers\admin;

use App\AssetBrand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AssetBrandController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-brands-read'])) {

            $assetbrands = AssetBrand::where('id', '>', 0);

            if ($request->get('title')) {
                $assetbrands->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            if ($request->has('type')) {
                if ($request->get('type') <> 2) {
                    $assetbrands->where('public', $request->get('type'));
                }
            }

            $assetbrands = $assetbrands->orderBy('title', 'ASC')->paginate(50);

            return view('admin.asset-brands.index', compact('assetbrands'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function create() {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-brands-create'])) {
            return view('admin.asset-brands.create');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-brands-create'])) {
            $messages = [
                    //
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('asset_brands')->whereNull('deleted_at'),
                ],
                    ], $messages);

            $input = $request->all();

            $input['admin_id'] = Auth::guard('admin')->user()->id;
            $input['public'] = 1;

            AssetBrand::create($input);

            Session::flash('success', 'The Asset Brand has been created');

            return redirect()->route('admin.asset-brands.index');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-brands-update'])) {
            $assetbrand = AssetBrand::find($id);
            return view('admin.asset-brands.edit', compact('assetbrand'));
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-brands-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('asset_brands')->whereNull('deleted_at')->ignore($id),
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

            $assetbrand = AssetBrand::find($id);
            $assetbrand->update($input);

            Session::flash('success', 'The Asset Brand has been updated');

            return redirect()->route('admin.asset-brands.index');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-brands-delete'])) {
            $assetbrand = AssetBrand::find($id);

            $assetbrand->update([
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $assetbrand->delete();

            Session::flash('success', 'The Asset Brand has been deleted');

            return redirect()->route('admin.asset-brands.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function pending(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-brands-pending'])) {

            $assetbrands = AssetBrand::where([['public', 0], ['user_id', '<>', 0]]);

            if ($request->get('title')) {
                $assetbrands->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            $assetbrands = $assetbrands->orderBy('title', 'ASC')->paginate(50);

            return view('admin.asset-brands.pending', compact('assetbrands'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function approved($id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-brands-approved'])) {
            $assetbrand = AssetBrand::find($id);

            $assetbrand->update([
                'admin_id' => Auth::guard('admin')->user()->id,
                'public' => 1,
            ]);
            Session::flash('success', 'The Asset Brand has been made public');

            return redirect()->route('admin.asset-brands.pending');
        } else {
            return view('error.admin-unauthorised');
        }
    }

}
