<?php

namespace App\Http\Controllers\vendor;

use App\Client;
use App\VendorEnlistment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:vendor');
    }

    public function index()
    {
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-clients-read'])) {

            $vendor_enlistments_id = VendorEnlistment::where([['vendor_id', Auth::guard('vendor')->user()->vendor_info_id]])->pluck('client_id')->all();

            $clients = Client::whereIn('id', $vendor_enlistments_id)->orderBy('created_at', 'DESC')->paginate(20);

            return view('vendor.clients.index', compact('clients'));
        } else {
            return view('error.vendor-unauthorised');
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-clients-read'])) {
            $vendor_enlistments_id = VendorEnlistment::where([['vendor_id', Auth::guard('vendor')->user()->vendor_info_id], ['status', 1]])->pluck('client_id')->all();

            if (in_array($id,$vendor_enlistments_id)) {
                $client = Client::find($id);
                return view('vendor.clients.show', compact('client'));
            } else {
                return view('error.vendor-unauthorised');
            }
        } else {
            return view('error.vendor-unauthorised');
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
        //
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
