<?php

namespace App\Http\Controllers\admin;

use App\Client;
use App\Assessment;
use App\VendorInfo;
use App\Workflow;
use App\Vendor;
use App\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['client-assessments-read'])) {

            $assets = [];
            $workflows = [];

            $assessments = Assessment::where('id', '>', 1);

            if ($request->get('client')) {
                $assessments->whereHas('asset', function($query) use($request) {
                    $query->where('client_id', $request->get('client'));
                });

                $workflows = Workflow::where([['client_id', $request->get('client')], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            }

            if ($request->get('workflow')) {
                $assessments->where('workflow_id', $request->get('workflow'));
                $assets = Asset::where([['client_id', $request->get('client')], ['workflow_id', $request->get('workflow')], ['archive', 0]])->pluck('title', 'id')->all();
            }

            if ($request->get('asset')) {
                $assessments->where('asset_id', $request->get('asset'));
            }

            if ($request->get('vendor')) {
                $assessments->where('vendor_id', $request->get('vendor'));
            }

            if ($request->get('cost')) {
                $assessments->where('cost', $request->get('cost'));
            }

            if ($request->get('submit_from')) {
                $assessments->whereDate('submit_date', '>=', $request->get('submit_from'));
            }

            if ($request->get('submit_to')) {
                $assessments->whereDate('submit_date', '<=', $request->get('submit_to'));
            }


            if ($request->has('status')) {
                if ($request->get('status') <> 4) {
                    $assessments->where('status', $request->get('status'));
                }
            }

            $assessments = $assessments->orderBy('created_at', 'DESC')->with('asset', 'workflow', 'vendor')->paginate(50);

            $vendors = VendorInfo::where('status', 1)->withTrashed()->orderBy('name', 'ASC')->pluck('name', 'id')->all();
            $clients = Client::where('status', 1)->orderBy('name', 'ASC')->pluck('name', 'id')->all();

            return view('admin.assessments.index', compact('assessments', 'workflows', 'vendors', 'assets', 'clients'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    public function timeline($id) {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-assessments-read'])) {
            $assessment = Assessment::find($id);
            return view('admin.assessments.timeline', compact('assessment'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

}
