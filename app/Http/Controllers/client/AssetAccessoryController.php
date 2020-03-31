<?php

namespace App\Http\Controllers\client;

use App\AssetHardware;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AssetAccessoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-hardwares-read'])) {

            $assethardwares = AssetHardware::where(function ($query) {
                $query->where('public', 1)->orWhere('client_id', Auth::user()->client_id);
            });

            if ($request->get('title')) {
                $assethardwares->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            if ($request->has('type')) {
                if ($request->get('type') <> 2) {
                    $assethardwares->where('public', $request->get('type'));
                }
            }

            $assethardwares = $assethardwares->orderBy('title', 'ASC')->paginate(50);

            return view('client.asset-accessories.index', compact('assethardwares', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-hardwares-create'])) {
            return view('client.asset-accessories.create', compact('subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-hardwares-create'])) {
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

            $input['client_id'] = Auth::user()->client_id;
            $input['user_id'] = Auth::user()->id;

            AssetHardware::create($input);

            Session::flash('success', 'The Asset Accessory has been created');

            return redirect()->route('client.asset-accessories.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-hardwares-update'])) {
            $assethardware = AssetHardware::find($id);
            return view('client.asset-accessories.edit', compact('assethardware', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-hardwares-update'])) {
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
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $assethardware = AssetHardware::find($id);
            $assethardware->update($input);

            Session::flash('success', 'The Asset Accessory has been updated');

            return redirect()->route('client.asset-accessories.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-hardwares-delete'])) {
            $assethardware = AssetHardware::find($id);

            $assethardware->update([
                'user_id' => Auth::user()->id,
            ]);

            $assethardware->delete();

            Session::flash('success', 'The Asset Accessory has been deleted');

            return redirect()->route('client.asset-accessories.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
