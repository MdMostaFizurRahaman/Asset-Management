<?php

namespace App\Http\Controllers\admin;

use App\Client;
use App\Role;
use App\VendorInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class VendorInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-infos-read'])) {

            $vendor_infos = VendorInfo::orderBy('name', 'ASC');
            //for searching--
            if ($request->get('name')) {
                $vendor_infos->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('email')) {
                $vendor_infos->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }

            if ($request->get('phone')) {
                $vendor_infos->where('phone', $request->get('phone'));
            }

            $vendor_infos = $vendor_infos->paginate(50);

            return view('admin.vendors.index', compact('vendor_infos'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-infos-create'])) {
//            dd('work');
            return view('admin.vendors.create');
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-infos-create'])) {

            $messages = [
                'vendor_id.required' => 'Vendor identity field is required',
                'name.required' => 'Name field is required',
                'email.required' => 'Email field is required',
                'email.unique' => 'Email already exists',
            ];

            $this->validate($request, [
                'name' => 'required|max:191',
                'email' => [
                    'required',
                    Rule::unique('vendor_infos', 'email')->whereNull('deleted_at'),
                    'email'
                ],
                'secondary_email' => 'sometimes|nullable|email',
                'phone' => [
                    'required',
                    'regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                ],
                'vendor_id' => [
                    'required',
                    'alpha_num',
                    Rule::unique('vendor_infos', 'vendor_id'),
                ],
                'contact_person_name' => 'required',
                'contact_person_phone' => 'required',
                'contact_person_email' => 'required|email',
                'address' => 'required',
            ], $messages);

            $input = $request->all();

            $input['admin_id'] = Auth::guard('admin')->user()->id;
            $vendor_infos = VendorInfo::create($input);

            Role::create([
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Admin Role for ' . $vendor_infos->name . " Vendor",
                'user_id' => $vendor_infos->id,
                'type' => 3,
            ]);

            Session::flash('success', 'The Vendor has been created');

            return redirect()->route('admin.vendors.index');
        } else {
            return view('error.admin-unauthorised');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-infos-read'])) {
            $vendorinfo = VendorInfo::findOrFail($id);
            return view('admin.vendors.show', compact('vendorinfo'));
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-infos-update'])) {
            $vendorInfo = VendorInfo::findOrFail($id);
            return view('admin.vendors.edit', compact('vendorInfo'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-infos-update'])) {

            $messages = [
                'vendor_id.required' => 'Vendor identity field is required',
                'name.required' => 'Name field is required',
                'email.required' => 'Email field is required',
                'email.unique' => 'Email already exists',
            ];

            $rules = [
                'name' => 'required|max:191',
                'email' => [
                    'required',
                    Rule::unique('vendor_infos', 'email')->whereNull('deleted_at')->ignore($id),
                    'email'
                ],
                'secondary_email' => 'sometimes|nullable|email',
                'phone' => [
                    'required',
                    'regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                ],
                'vendor_id' => [
                    'required',
                    'alpha_num',
                    Rule::unique('vendor_infos', 'vendor_id')->ignore($id),
                ],
                'contact_person_name' => 'required',
                'contact_person_phone' => 'required',
                'contact_person_email' => 'required|email',
                'address' => 'required',
            ];


            $this->validate($request, $rules, $messages);

            $input = $request->all();
            if (!$request->has('status')) {
                $input['status'] = 0;
            }
            $input['admin_id'] = Auth::guard('admin')->user()->id;

            $vendorInfo = VendorInfo::findOrFail($id);
            $vendorInfo->update($input);

            Session::flash('success', 'The Vendor has been updated');

            return redirect()->route('admin.vendors.index');
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-infos-delete'])) {

            $vendorInfo = VendorInfo::findOrFail($id);
            $vendorInfo->update([
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $vendorInfo->delete();

            Session::flash('success', 'The Client has been deleted');

            return redirect()->route('admin.vendors.index');
        } else {
            return view('error.admin-unauthorised');
        }
    }
}
