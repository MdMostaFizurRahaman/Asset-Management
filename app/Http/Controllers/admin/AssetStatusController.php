<?php

namespace App\Http\Controllers\admin;

use App\AssetStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AssetStatusController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-statuses-read'])) {

            $assetstatuses = AssetStatus::where('id', '>', 0);

            if ($request->get('title')) {
                $assetstatuses->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            $assetstatuses = $assetstatuses->orderBy('title', 'ASC')->paginate(50);

            return view('admin.asset-statuses.index', compact('assetstatuses'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function create()
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-statuses-create'])) {
            return view('admin.asset-statuses.create');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function store(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-statuses-create'])) {
            $messages = [
                //
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('asset_statuses')->whereNull('deleted_at'),
                ],
                'color_code' => 'required',
            ], $messages);

            $input = $request->all();
            $input['admin_id'] = Auth::guard('admin')->user()->id;

            AssetStatus::create($input);

            Session::flash('success', 'The Asset Status has been created');

            return redirect()->route('admin.asset-statuses.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-statuses-update'])) {
            $assetstatus = AssetStatus::find($id);
            return view('admin.asset-statuses.edit', compact('assetstatus'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-statuses-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('asset_statuses')->whereNull('deleted_at')->ignore($id),
                ],
                'color_code' => 'required',
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

            $assetstatus = AssetStatus::find($id);
            $assetstatus->update($input);

            Session::flash('success', 'The Asset Status has been updated');

            return redirect()->route('admin.asset-statuses.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-statuses-delete'])) {
            $assetstatus = AssetStatus::find($id);

            $assetstatus->update([
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $assetstatus->delete();

            Session::flash('success', 'The Asset Status has been deleted');

            return redirect()->route('admin.asset-statuses.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }

}
