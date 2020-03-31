<?php

namespace App\Http\Controllers\client;

use App\OfficeLocation;
use App\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-store-read')) {
            $stores = Store::where(function ($query) {
                $query->where('client_id', Auth::user()->client_id);
            });
            if ($request->get('title')) {
                $stores->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            if ($request->get('location')) {
                $stores->where('office_location_id', $request->get('location'));
            }

            $locations = OfficeLocation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $stores = $stores->with('location')->orderBy('title', 'ASC')->paginate(50);
            return view('client.stores.index', compact('locations', 'stores', 'subdomain'));

        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-store-create')) {

            $locations = OfficeLocation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();

            return view('client.stores.create', compact('locations', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-store-create')) {
            $messages = [
                'office_location_id.required' => 'Please select a office location.',
            ];

            $this->validate($request, [
                'office_location_id' => 'required',
                'title' => [
                    'required',
                    Rule::unique('stores')->where('office_location_id', $request->office_location_id)->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                ],
            ], $messages);

            $input = $request->all();

            $input['company_id'] = Auth::user()->company_id;
            $input['client_id'] = Auth::user()->client_id;
            $input['user_id'] = Auth::user()->id;

            Store::create($input);
            Session::flash('success', 'The Asset Store has been created');
            return redirect()->route('client.stores.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-store-update')) {
            $store = Store::findOrFail($id);
            $locations = OfficeLocation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('client.stores.edit', compact('store', 'locations', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, Request $request, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-store-update')) {
            $rules = [
                'office_location_id' => 'required',
                'title' => [
                    'required',
                    Rule::unique('stores')->where('office_location_id', $request->office_location_id)->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($id),
                ],
            ];

            $messages = [
                'office_location_id.required' => 'Please select a office location.',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $store = Store::findOrFail($id);
            $store->update($input);

            Session::flash('success', 'The Asset Store has been updated');

            return redirect()->route('client.stores.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-store-delete')) {

            $store = Store::findOrFail($id);
            $store->update([
                'user_id' => Auth::user()->id,
            ]);
            $store->delete();

            Session::flash('success', 'The Asset Store has been deleted');

            return redirect()->route('client.stores.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }
}
