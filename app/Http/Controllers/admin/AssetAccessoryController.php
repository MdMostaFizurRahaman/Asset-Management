<?php

namespace App\Http\Controllers\admin;

use App\AssetHardware;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AssetAccessoryController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-hardwares-read'])) {

            $assethardwares = AssetHardware::where('id', '>', 0);

            if ($request->get('title')) {
                $assethardwares->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            if ($request->has('type')) {
                if ($request->get('type') <> 2) {
                    $assethardwares->where('public', $request->get('type'));
                }
            }

            $assethardwares = $assethardwares->orderBy('title', 'ASC')->paginate(50);

            return view('admin.asset-accessories.index', compact('assethardwares'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function create() {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-hardwares-create'])) {
            return view('admin.asset-accessories.create');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-hardwares-create'])) {
            $messages = [
                    //
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('asset_hardwares')->whereNull('deleted_at'),
                ],
                    ], $messages);

            $input = $request->all();

            $input['admin_id'] = Auth::guard('admin')->user()->id;
            $input['public'] = 1;

            AssetHardware::create($input);

            Session::flash('success', 'The Asset Accessory has been created');

            return redirect()->route('admin.asset-accessories.index');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-hardwares-update'])) {
            $assethardware = AssetHardware::find($id);
            return view('admin.asset-accessories.edit', compact('assethardware'));
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-hardwares-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('asset_hardwares')->whereNull('deleted_at')->ignore($id),
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

            $assethardware = AssetHardware::find($id);
            $assethardware->update($input);

            Session::flash('success', 'The Asset Accessory has been updated');

            return redirect()->route('admin.asset-accessories.index');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-hardwares-delete'])) {
            $assethardware = AssetHardware::find($id);

            $assethardware->update([
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $assethardware->delete();

            Session::flash('success', 'The Asset Accessory has been deleted');

            return redirect()->route('admin.asset-accessories.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function pending(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-hardwares-pending'])) {
            $assethardwares = AssetHardware::where([['public', 0], ['user_id', '<>', 0]]);

            if ($request->get('title')) {
                $assethardwares->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            $assethardwares = $assethardwares->orderBy('title', 'ASC')->paginate(50);

            return view('admin.asset-accessories.pending', compact('assethardwares'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function approved($id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-hardwares-approved'])) {
            $assethardware = AssetHardware::find($id);

            $assethardware->update([
                'admin_id' => Auth::guard('admin')->user()->id,
                'public' => 1,
            ]);
            Session::flash('success', 'The Asset Accessory has been made public');

            return redirect()->route('admin.asset-accessories.pending');
        } else {
            return view('error.admin-unauthorised');
        }
    }

}
