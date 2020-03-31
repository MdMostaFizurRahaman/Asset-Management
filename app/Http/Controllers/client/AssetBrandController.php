<?php

namespace App\Http\Controllers\client;

use App\AssetBrand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AssetBrandController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-brands-read'])) {

            $assetbrands = AssetBrand::where(function ($query) {
                $query->where('public', 1)->orWhere('client_id', Auth::user()->client_id);
            });

            if ($request->get('title')) {
                $assetbrands->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            if ($request->has('type')) {
                if ($request->get('type') <> 2) {
                    $assetbrands->where('public', $request->get('type'));
                }
            }

            $assetbrands = $assetbrands->orderBy('title', 'ASC')->paginate(50);

            return view('client.asset-brands.index', compact('assetbrands', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-brands-create'])) {
            return view('client.asset-brands.create', compact('subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-brands-create'])) {
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
            $input['user_id'] = Auth::user()->id;
            $input['client_id'] = Auth::user()->client_id;
            AssetBrand::create($input);

            Session::flash('success', 'The Asset Brand has been created');

            return redirect()->route('client.asset-brands.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-brands-update'])) {
            $assetbrand = AssetBrand::find($id);
            return view('client.asset-brands.edit', compact('assetbrand', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-brands-update'])) {
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
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $assetbrand = AssetBrand::find($id);
            $assetbrand->update($input);

            Session::flash('success', 'The Asset Brand has been updated');

            return redirect()->route('client.asset-brands.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-brands-delete'])) {
            $assetbrand = AssetBrand::find($id);

            $assetbrand->update([
                'user_id' => Auth::user()->id,
            ]);

            $assetbrand->delete();

            Session::flash('success', 'The Asset Brand has been deleted');

            return redirect()->route('client.asset-brands.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
