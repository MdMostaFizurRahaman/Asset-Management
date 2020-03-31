<?php

namespace App\Http\Controllers\client;

use App\AssetService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AssetServiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-services-read'])) {

            $assetservices = AssetService::where(function ($query) {
                $query->where('public', 1)->orWhere('client_id', Auth::user()->client_id);
            });

            if ($request->get('title')) {
                $assetservices->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            if ($request->has('type')) {
                if ($request->get('type') <> 2) {
                    $assetservices->where('public', $request->get('type'));
                }
            }

            $assetservices = $assetservices->orderBy('title', 'ASC')->paginate(50);

            return view('client.asset-services.index', compact('assetservices', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-services-create'])) {
            return view('client.asset-services.create', compact('subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-services-create'])) {
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

            $input['client_id'] = Auth::user()->client_id;
            $input['user_id'] = Auth::user()->id;

            AssetService::create($input);

            Session::flash('success', 'The Asset Service has been created');

            return redirect()->route('client.asset-services.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-services-update'])) {
            $assetservice = AssetService::find($id);
            return view('client.asset-services.edit', compact('assetservice', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-services-update'])) {
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
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $assetservice = AssetService::find($id);
            $assetservice->update($input);

            Session::flash('success', 'The Asset Service has been updated');

            return redirect()->route('client.asset-services.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-services-delete'])) {
            $assetservice = AssetService::find($id);

            $assetservice->update([
                'user_id' => Auth::user()->id,
            ]);

            $assetservice->delete();

            Session::flash('success', 'The Asset Service has been deleted');

            return redirect()->route('client.asset-services.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
