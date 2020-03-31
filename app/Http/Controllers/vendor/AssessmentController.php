<?php

namespace App\Http\Controllers\vendor;

use App\AssessmentApprovalUserArchive;
use App\AssetVendorPermission;
use App\Client;
use App\AssessmentService;
use App\AssessmentAccessory;
use App\Asset;
use App\Mail\WaitingForApproval;
use App\ProcessUser;
use App\User;
use App\VendorEnlistment;
use App\Workflow;
use App\Assessment;
use App\AssessmentApproval;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Carbon\Carbon;

class AssessmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:vendor');
    }

    public function index($id)
    {
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-assessments-read'])) {
            $vendor_enlistments = VendorEnlistment::where([['vendor_id', Auth::guard('vendor')->user()->vendor_info_id]])->get();
            $vendor_enlistment_id = $vendor_enlistments->pluck('client_id')->all();

            if (in_array($id, $vendor_enlistment_id)) {
                $client = Client::find($id);

                $asset_permission = $vendor_enlistments->where('client_id', $id)->where('status', 1)->pluck('asset_permission')->first();

                $assets = [];
                if ($asset_permission == 1) {
                    $assets = Asset::where([['client_id', $id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
                } else if ($asset_permission == 2) {
                    $permitted_assets = AssetVendorPermission::where('vendor_id', Auth::guard('vendor')->user()->vendor_info_id)->where('permission_end_date', null)->orWhere('permission_end_date', '>=', Carbon::today())->get();
                    $permitted_assets_id = $permitted_assets->pluck('asset_id')->all();
                    $assets = Asset::whereIn('id', $permitted_assets_id)->where([['client_id', $id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
                }

                $assessments = Assessment::where('vendor_id', Auth::guard('vendor')->user()->vendor_info_id)->whereHas('asset', function ($query) use ($id) {
                    $query->where('client_id', $id);
                })->orderBy('created_at', 'DESC')->paginate(50);
                return view('vendor.assessments.index', compact('client', 'assets', 'assessments'));
            } else {
                return view('error.vendor-unauthorised');
            }

        } else {
            return view('error.vendor-unauthorised');
        }
    }

    public function create()
    {
        //
    }

    public function store($id, Request $request)
    {
//        dd('test');
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-assessments-create'])) {

            $rules = [
                'asset_id' => 'required',
                'required_days' => 'required|integer',
                'cost' => 'required|numeric',
            ];

            $messages = [
                'asset_id.required' => 'Please select an asset.',
                'required_days.required' => 'Please input how many days you required.',
                'required_days.integer' => 'Required days must be integer.',
                'cost.required' => 'Please input cost you demand.',
                'cost.numeric' => 'Costing must be numeric value.',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            $asset = Asset::find($input['asset_id']);
            $input['vendor_id'] = Auth::guard('vendor')->user()->vendor_info_id;
            $input['workflow_id'] = $asset->workflow_id;

            $workflow = Workflow::find($input['workflow_id']);
            $input['total_steps'] = $workflow->activeprocesses->count();
            $input['current_steps'] = $workflow->activeprocesses->first()->id;
            $input['submit_date'] = Carbon::now()->format('Y-m-d');
            $input['status'] = 0;
            $assessment = Assessment::create($input);


            Session::flash('success', 'The Assessment has been created');

            return redirect()->route('vendor.assessments.services', [$id, $assessment->id]);
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
    public function edit($client, $id)
    {
        return view('error.vendor-unauthorised');
//        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-assessments-update'])) {
//            $assessment = Assessment::find($id);
//            $assets = Asset::where([['client_id', $client], ['status', 1]])->orderBy('model', 'ASC')->pluck('model', 'id')->all();
//            return view('vendor.assessments.edit', compact('assessment', 'assets', 'client'));
//        } else {
//            return view('error.vendor-unauthorised');
//        }
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $client, $id)
    {
        return view('error.vendor-unauthorised');
//        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-assessments-update'])) {
//
//            $rules = [
//                'asset_id' => 'required',
//                'required_days' => 'required|integer',
//                'cost' => 'required|numeric',
//            ];
//
//            $messages = [
//                'asset_id.required' => 'Please select an asset.',
//                'required_days.required' => 'Please input how many days you required.',
//                'required_days.integer' => 'Required days must be integer.',
//                'cost.required' => 'Please input cost you demand.',
//                'cost.numeric' => 'Costing must be numeric value.',
//            ];
//
//            $this->validate($request, $rules, $messages);
//
//
//            $input = $request->all();
//
//            if (!$request->has('status')) {
//                $input['status'] = 0;
//            }
//
//            $assessment = Assessment::find($id);
//            $assessment->update($input);
//            Session::flash('success', 'The Assessment has been updated');
//
//            return redirect()->route('vendor.assessments.index', $client);
//        } else {
//            return view('error.vendor-unauthorised');
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($client, $id)
    {

        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-assessments-delete'])) {

            $assessment = Assessment::find($id);
            if ($assessment->status > 0) {
                return view('error.vendor-unauthorised');
            }
            $assessment['deleted'] = 1;
            $assessment->update();
            $assessment->delete();
            Session::flash('success', 'The Assessment has been deleted');

            return redirect()->back();
        } else {
            return view('error.vendor-unauthorised');
        }
    }

    public function services($client, $id)
    {
        if (Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-assessments-read'])) {
            $assessment = Assessment::find($id);
            $client = Client::find($client);
            if ($assessment->status > 0) {
                return view('error.vendor-unauthorised');
            }
            return view('vendor.assessments.services', compact('assessment', 'client'));
        } else {
            return view('error.vendor-unauthorised');
        }
    }

    public function servicestore($client, $id, Request $request)
    {
        $assessment = Assessment::find($id);
        if ($assessment->status > 0) {
            return view('error.vendor-unauthorised');
        }

        $rules = [
//            'services' => 'required_without:hardwares',
//            'hardwares' => 'required_without:services'
        ];

        $messages = [
            'services.required_without' => 'Please select at least one service if you not select any hardware.',
            'hardwares.required_without' => 'Please select at least one hardware if you not select any service.',
        ];

        $this->validate($request, $rules, $messages);

        if (!empty($request->get('services'))) {
            foreach ($request->get('services') as $service) {
                $services[] = AssessmentService::updateOrCreate([
                    'assessment_id' => $id,
                    'service_id' => $service,
                ], [
                        'assessment_id' => $id,
                        'service_id' => $service,
                    ]
                );
            }

            AssessmentService::where('assessment_id', $id)->whereNotIn('service_id', collect($services)->pluck('service_id')->all())->delete();
        }


        if (!empty($request->get('hardwares'))) {
            foreach ($request->get('hardwares') as $hardware) {
                $accessories[] = AssessmentAccessory::updateOrCreate([
                    'assessment_id' => $id,
                    'accessory_id' => $hardware,
                ], [
                        'assessment_id' => $id,
                        'accessory_id' => $hardware,
                    ]
                );
            }

            AssessmentAccessory::where('assessment_id', $id)->whereNotIn('accessory_id', collect($accessories)->pluck('accessory_id')->all())->delete();
        }


        //Start workflow and email notification
        Helper::startWorkflowSendEmail($id);

        Session::flash('success', 'The Service, Accessory has been updated');
        return redirect()->route('vendor.assessments.index', $client);
    }

}
