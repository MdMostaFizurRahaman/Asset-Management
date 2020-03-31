<?php

namespace App\Http\Controllers\client;


use App\Helpers\Helper;
use App\VendorEnlistment;
use App\VendorEnlistmentAttachment;
use App\VendorInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class VendorEnlistmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function vendor($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-vendor-enlistment-create'])) {

            $vendors = VendorInfo::where('status', 1)->whereDoesntHave('vendorExistence', function ($query) {
                $query->where([['client_id', Auth::user()->client_id], ['company_id', Auth::user()->company_id]]);
            })->orderBy('name', 'ASC');

            if ($request->get('name')) {
                $vendors->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('email')) {
                $vendors->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }

            if ($request->get('phone')) {
                $vendors->where('phone', $request->get('phone'));
            }

            if ($request->get('address')) {
                $vendors->where('address', $request->get('address'));
            }

            $vendors = $vendors->with('vendorExistence')->paginate(50);

            return view('client.vendor-enlistment.vendor', compact('vendors', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-vendor-enlistment-read')) {

            $vendors = VendorEnlistment::where('client_id', Auth::user()->client_id);

            if ($request->get('vendor')) {
                $vendors->where('vendor_id', 'LIKE', '%' . $request->get('vendor') . '%');
            }

            $vendors = $vendors->with('vendors')->paginate(50);

            $existvendors = VendorInfo::with('vendorExistence')->whereHas('vendorExistence', function ($query) {
                $query->where([['client_id', Auth::user()->client_id]]);
            })->orderBy('name', 'ASC')->pluck('name', 'id')->all();

            return view('client.vendor-enlistment.index', compact('existvendors', 'vendors', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-vendor-enlistment-create')) {
            $vendor = VendorInfo::findOrFail($id);
            return view('client.vendor-enlistment.create', compact('vendor', 'subdomain'));
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
    public function store($subdomain, $id, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-vendor-enlistment-create')) {
            $messages = [
                //
            ];

            $this->validate($request, [
                'enlist_date' => 'required'
            ], $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;
            $input['client_id'] = Auth::user()->client_id;
            $input['company_id'] = Auth::user()->company_id;
            $input['vendor_id'] = $id;

            VendorEnlistment::create($input);
            Session::flash('success', 'The Vendor has been Enlisted');

            return redirect()->route('client.vendor-enlistments.index', $subdomain);

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
    public function show($subdomain, $id)
    {
        $enlistvendor = VendorEnlistment::findOrFail($id);
        return view('client.vendor-enlistment.show', compact('enlistvendor', 'subdomain'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-vendor-enlistment-update')) {
            $enlistvendor = VendorEnlistment::findOrFail($id);
            return view('client.vendor-enlistment.edit', compact('enlistvendor', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-vendor-enlistment-update')) {
            $enlistvendor = VendorEnlistment::findOrFail($id);

            $messages = [
                //
            ];

            $this->validate($request, [
                'enlist_date' => 'required'
            ], $messages);

            $input = $request->all();
            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $input['user_id'] = Auth::user()->id;

            $enlistvendor->update($input);
            Session::flash('success', 'The Enlistment Vendor has been updated');

            return redirect()->route('client.vendor-enlistments.index', $subdomain);
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-vendor-enlistment-delete'])) {
            $enlistvendor = VendorEnlistment::findOrFail($id);

            $enlistvendor->update([
                'user_id' => Auth::user()->id,
            ]);

            $enlistvendor->delete();

            Session::flash('success', 'The Enlistment Vendor has been deleted');

            return redirect()->route('client.vendor-enlistments.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    //File Attachment
    public function attachfile($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-vendor-enlistment-update'])) {

            $enlistvendor = VendorEnlistment::findOrFail($id);
            $attachments = VendorEnlistmentAttachment::where('vendor_enlistment_id', $id)->with('users')->get();

            return view('client.vendor-enlistment.attachfile', compact('enlistvendor', 'attachments', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function attachfilestore($subdomain, $id, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-vendor-enlistment-update'])) {
            $enlistvendor = VendorEnlistment::findOrFail($id);

            $messages = [

            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('vendor_enlistment_attachments')->where('vendor_enlistment_id', $id),
                ],
                'file' => 'required',
            ], $messages);

            $input['user_id'] = Auth::user()->id;
            $enlistvendor->update($input);

            //Vendor Enlistment File Attachment
            $attach = $request->all();
            $attach['user_id'] = Auth::user()->id;
            $attach['vendor_enlistment_id'] = $enlistvendor->id;

            if ($request->file('file')) {
                $filePath = Helper::uploadFile($request->file('file'), null, Config::get('constants.VENDOR_ATTACHMENT'));
                $attach['filename'] = $filePath;
            }
            $attachment = VendorEnlistmentAttachment::create($attach);

            Session::flash('success', 'The Vendor Enlistment File has been Attached');
            return redirect()->route('client.vendor-enlistments.attach.file', [$subdomain,$id]);

        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function attachmentdestroy($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-vendor-enlistment-attachment-delete')) {

            $attach = VendorEnlistmentAttachment::findOrFail($id);
            $enlistvendor = VendorEnlistment::findOrFail($attach->vendor_enlistment_id);

            $enlistvendor->update([
                'user_id' => Auth::user()->id,
            ]);

            $attach->delete();
            Session::flash('success', 'The Vendor Enlistment File has been Deleted');
            return redirect()->route('client.vendor-enlistments.attach.file', [$subdomain,$enlistvendor->id]);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    // Client asset permission to vendor
    public function assetpermission($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-permission-create'])) {

            $enlistvendor = VendorEnlistment::findOrFail($id);

            return view('client.vendor-enlistment.assetpermission', compact('enlistvendor', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function assetpermissionstore($subdomain, $id, Request $request)
    {

        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-permission-create'])) {
            $enlistvendor = VendorEnlistment::findOrFail($id);

            $messages = [

            ];

            $this->validate($request, [
                'asset_permission' => 'numeric',
            ], $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;
            $enlistvendor->update($input);

            Session::flash('success', 'The Vendor Asset Permission has been Created');
            return redirect()->route('client.vendor-enlistments.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }

    }

    //end class
}
