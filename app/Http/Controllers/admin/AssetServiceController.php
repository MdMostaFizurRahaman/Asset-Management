<?php

namespace App\Http\Controllers\admin;

use App\AssetService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AssetServiceController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-services-read'])) {

            $assetservices = AssetService::where('id', '>', 0);

            if ($request->get('title')) {
                $assetservices->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            if ($request->has('type')) {
                if ($request->get('type') <> 2) {
                    $assetservices->where('public', $request->get('type'));
                }
            }

            $assetservices = $assetservices->orderBy('title', 'ASC')->paginate(50);
            return view('admin.asset-services.index', compact('assetservices'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function create() {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-services-create'])) {
            return view('admin.asset-services.create');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-services-create'])) {
            $messages = [
                    //
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('asset_services')->whereNull('deleted_at'),
                ],
                    ], $messages);

            $input = $request->all();

            $input['admin_id'] = Auth::guard('admin')->user()->id;
            $input['public'] = 1;

            AssetService::create($input);

            Session::flash('success', 'The Asset Service has been created');

            return redirect()->route('admin.asset-services.index');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-services-update'])) {
            $assetservice = AssetService::find($id);
            return view('admin.asset-services.edit', compact('assetservice'));
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-services-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('asset_services')->whereNull('deleted_at')->ignore($id),
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

            $assetservice = AssetService::find($id);
            $assetservice->update($input);

            Session::flash('success', 'The Asset Service has been updated');

            return redirect()->route('admin.asset-services.index');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-services-delete'])) {
            $assetservice = AssetService::find($id);

            $assetservice->update([
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $assetservice->delete();

            Session::flash('success', 'The Asset Service has been deleted');

            return redirect()->route('admin.asset-services.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function pending(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-services-pending'])) {

            $assetservices = AssetService::where([['public', 0], ['user_id', '<>', 0]]);

            if ($request->get('title')) {
                $assetservices->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            $assetservices = $assetservices->orderBy('title', 'ASC')->paginate(50);

            return view('admin.asset-services.pending', compact('assetservices'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function approved($id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-services-approved'])) {
            $assetservice = AssetService::find($id);

            $assetservice->update([
                'admin_id' => Auth::guard('admin')->user()->id,
                'public' => 1,
            ]);
            Session::flash('success', 'The Asset Service has been made public');

            return redirect()->route('admin.asset-services.pending');
        } else {
            return view('error.admin-unauthorised');
        }
    }

}
