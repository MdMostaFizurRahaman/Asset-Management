<?php

namespace App\Http\Controllers\client;

use App\AssessmentAccessory;
use App\AssessmentApproval;
use App\AssessmentApprovalUser;
use App\Assessment;
use App\AssessmentApprovalUserArchive;
use App\AssessmentService;
use App\Mail\approvalRejectToAdmin;
use App\Mail\approvalSuccessToAdmin;
use App\Mail\WaitingForApproval;
use App\ProcessUser;
use App\Role;
use App\User;
use App\VendorInfo;
use App\Workflow;
use App\Vendor;
use App\Asset;
use DemeterChain\A;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AssessmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function pendinglist($subdomain, Request $request)
    {

        $approvals = AssessmentApproval::whereHas('approvalusers', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->pluck('id')->all();

        $assessments = AssessmentApproval::whereNotIn('id', $approvals)->where('status', 1)->whereHas('process.users', function ($query) {
            $query->where('attachuser_id', Auth::user()->id);
        });

        $assets = Asset::where([['status', 1], ['user_id', Auth::user()->id]])->whereHas('assessments')->orderBy('title', 'ASC')->pluck('title', 'id')->all();

        if ($request->get('workflow')) {
            $assessments->whereHas('assessment', function ($query) use ($request) {
                $query->where('workflow_id', $request->get('workflow'));
            });
            $assets = Asset::where([['client_id', Auth::user()->client_id], ['workflow_id', $request->get('workflow')], ['archive', 0]])->pluck('title', 'id')->all();
        }

        if ($request->get('asset')) {

            $assessments->whereHas('assessment', function ($query) use ($request) {
                $query->where('asset_id', $request->get('asset'));
            });
        }

        if ($request->get('vendor')) {

            $assessments->whereHas('assessment', function ($query) use ($request) {
                $query->where('vendor_id', $request->get('vendor'));
            });
        }

        if ($request->get('cost')) {

            $assessments->whereHas('assessment', function ($query) use ($request) {
                $query->where('cost', $request->get('cost'));
            });
        }

        if ($request->get('submit_from')) {

            $assessments->whereHas('assessment', function ($query) use ($request) {
                $query->whereDate('submit_date', '>=', $request->get('submit_from'));
            });
        }

        if ($request->get('submit_to')) {
            $assessments->whereHas('assessment', function ($query) use ($request) {
                $query->whereDate('submit_date', '<=', $request->get('submit_to'));
            });
        }

        if ($request->has('type')) {
            if ($request->get('type') <> 2) {
                $assessments->where('type', $request->get('type'));
            }
        }

        $assessments = $assessments->orderBy('created_at', 'DESC')->with('assessment', 'assessment.asset', 'assessment.workflow', 'assessment.vendor', 'assessment.currentstep')->paginate(50);

        $workflows = Workflow::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
        $vendors = Vendor::where('status', 1)->orderBy('name', 'ASC')->pluck('name', 'id')->all();

        return view('client.assessments.pendinglist', compact('assessments', 'subdomain', 'workflows', 'vendors', 'assets'));
    }

    public function approvelist($subdomain, Request $request)
    {

        $assets = [];

        $approvals = AssessmentApproval::whereHas('approvalusers', function ($query) {
            $query->where('user_id', Auth::user()->id)->where('status', 1);
        });
        $assets = Asset::where([['status', 1], ['user_id', Auth::user()->id]])->whereHas('assessments')->orderBy('title', 'ASC')->pluck('title', 'id')->all();

        if ($request->get('workflow')) {

            $approvals->whereHas('assessment', function ($query) use ($request) {
                $query->where('workflow_id', $request->get('workflow'));
            });

            $assets = Asset::where([['client_id', Auth::user()->client_id], ['workflow_id', $request->get('workflow')], ['archive', 0]])->pluck('title', 'id')->all();
        }

        if ($request->get('asset')) {

            $approvals->whereHas('assessment', function ($query) use ($request) {
                $query->where('asset_id', $request->get('asset'));
            });
        }

        if ($request->get('vendor')) {

            $approvals->whereHas('assessment', function ($query) use ($request) {
                $query->where('vendor_id', $request->get('vendor'));
            });
        }

        if ($request->get('cost')) {

            $approvals->whereHas('assessment', function ($query) use ($request) {
                $query->where('cost', $request->get('cost'));
            });
        }

        if ($request->get('submit_from')) {

            $approvals->whereHas('assessment', function ($query) use ($request) {
                $query->whereDate('submit_date', '>=', $request->get('submit_from'));
            });
        }

        if ($request->get('submit_to')) {
            $approvals->whereHas('assessment', function ($query) use ($request) {
                $query->whereDate('submit_date', '<=', $request->get('submit_to'));
            });
        }

        if ($request->has('type')) {
            if ($request->get('type') <> 2) {
                $approvals->where('type', $request->get('type'));
            }
        }

        $approvals = $approvals->orderBy('created_at', 'DESC')->with('assessment', 'assessment.asset', 'assessment.workflow', 'assessment.vendor', 'assessment.currentstep', 'userapproved')->paginate(50);

        $workflows = Workflow::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
        $vendors = Vendor::where('status', 1)->orderBy('name', 'ASC')->pluck('name', 'id')->all();

        return view('client.assessments.approvelist', compact('approvals', 'subdomain', 'workflows', 'vendors', 'assets'));
    }

    public function rejectlist($subdomain, Request $request)
    {

        $assets = [];
        $rejects = AssessmentApproval::whereHas('approvalusers', function ($query) {
            $query->where('user_id', Auth::user()->id)->where('status', 2);
        });
        $assets = Asset::where([['status', 1], ['user_id', Auth::user()->id]])->whereHas('assessments')->orderBy('title', 'ASC')->pluck('title', 'id')->all();
        if ($request->get('workflow')) {

            $rejects->whereHas('assessment', function ($query) use ($request) {
                $query->where('workflow_id', $request->get('workflow'));
            });

            $assets = Asset::where([['client_id', Auth::user()->client_id], ['workflow_id', $request->get('workflow')], ['archive', 0]])->pluck('title', 'id')->all();
        }

        if ($request->get('asset')) {

            $rejects->whereHas('assessment', function ($query) use ($request) {
                $query->where('asset_id', $request->get('asset'));
            });
        }

        if ($request->get('vendor')) {

            $rejects->whereHas('assessment', function ($query) use ($request) {
                $query->where('vendor_id', $request->get('vendor'));
            });
        }

        if ($request->get('cost')) {

            $rejects->whereHas('assessment', function ($query) use ($request) {
                $query->where('cost', $request->get('cost'));
            });
        }

        if ($request->get('submit_from')) {

            $rejects->whereHas('assessment', function ($query) use ($request) {
                $query->whereDate('submit_date', '>=', $request->get('submit_from'));
            });
        }

        if ($request->get('submit_to')) {
            $rejects->whereHas('assessment', function ($query) use ($request) {
                $query->whereDate('submit_date', '<=', $request->get('submit_to'));
            });
        }

        if ($request->has('type')) {
            if ($request->get('type') <> 2) {
                $rejects->where('type', $request->get('type'));
            }
        }

        $rejects = $rejects->orderBy('created_at', 'DESC')->with('assessment', 'assessment.asset', 'assessment.workflow', 'assessment.vendor', 'assessment.currentstep', 'userreject')->paginate(50);

        $workflows = Workflow::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
        $vendors = Vendor::where('status', 1)->orderBy('name', 'ASC')->pluck('name', 'id')->all();

        return view('client.assessments.rejectlist', compact('rejects', 'subdomain', 'workflows', 'vendors', 'assets'));
    }

//approvalreject

    public function approvalreject($subdomain, $id)
    {
        $data = AssessmentApproval::findOrFail($id);
        $assessment = $data->assessment;
        //Authenticate User
//        $userCheck = 1;
//        $processUserIds = ProcessUser::where('process_id', $assessment->current_steps)->pluck('attachuser_id', 'attachuser_id')->all();
//        if (!in_array(Auth::user()->id, $processUserIds)) {
//            $userCheck = 0;
//        }

        $instrument = [];
        $instrument['assessmentaccessories'] = AssessmentAccessory::where('assessment_id', $data->assessment_id)->pluck('accessory_id')->all();
        $instrument['assessmentservices'] = AssessmentService::where('assessment_id', $data->assessment_id)->pluck('service_id')->all();
        $checkSubmit = AssessmentApprovalUser::where('user_id', Auth::user()->id)->where('assessment_approval_id', $id)->first();

        return view('client.assessments.approvalreject', compact('data', 'instrument', 'checkSubmit', 'subdomain'));
    }

    public function approvalrejectstore($subdomain, $id, Request $request)
    {
        // for approval
        if ($request->submit === 'approved') {
            $approval = AssessmentApproval::find($id);
            $assessment = $approval->assessment;
            $process = $assessment->currentstep;
            $workflow = $assessment->workflow;
            $admin_roles = Role::where('name', 'admin')->pluck('id', 'id');
            $admin_users = User::where('client_id', Auth::user()->client_id)->whereIn('role_id', $admin_roles)->pluck('id', 'id');
            //Authenticate User
            $processUserIds = ProcessUser::where('process_id', $assessment->current_steps)->pluck('attachuser_id', 'attachuser_id')->all();
            if (!in_array(Auth::user()->id, $processUserIds)) {
                return view('error.client-unauthorised', compact('subdomain'));
            }

            //Check previous submit or not
            $checkSubmit = AssessmentApprovalUser::where('user_id', Auth::user()->id)->where('assessment_approval_id', $id)->first();
            if ($checkSubmit !=null) {
                Session::flash('warning', 'You are already submitted your Opinion');
                return redirect()->back();
            }
            AssessmentApprovalUser::create([
                'assessment_approval_id' => $id,
                'user_id' => Auth::user()->id,
                'status' => 1,
                'note' => $request->get('note'),
                'ip' => $request->ip(),
            ]);

            if ($process->type == 1) {
                $approval->update([
                    'status' => 2
                ]);

                $newprocess = $workflow->activeprocesses->where('id', '<>', $assessment->current_steps)->where('order', '>', $process->order)->first();

                if ($newprocess) {
                    $assessment_approval = AssessmentApproval::create([
                        'process_id' => $newprocess->id,
                        'assessment_id' => $assessment->id,
                        'status' => 1,
                        'type' => 0,
                    ]);

                    $this->insertUser($newprocess, $assessment_approval);

                    $assessment->update([
                        'current_steps' => $newprocess->id,
                    ]);

                    //send emails
                    $processUserIds = ProcessUser::where('process_id', $assessment->current_steps)->pluck('attachuser_id', 'attachuser_id');

                    if ($processUserIds) {
                        $processUsers = User::whereIn('id', $processUserIds)->get();
                        foreach ($processUsers as $processUser) {
                            Mail::to($processUser->email)->queue(new WaitingForApproval($processUser, $assessment_approval->id));
                        }
                    }
                    //send emails


                } else {
                    $assessment->update([
                        'status' => 2,
                    ]);
                    //if approved send admin to approved message

                    if ($admin_users) {
                        $adminUsers = User::whereIn('id', $admin_users)->get();
                        foreach ($adminUsers as $adminUser) {
                            Mail::to($adminUser->email)->queue(new approvalSuccessToAdmin($adminUser));
                        }
                    }
                    //send emails
                }
            } elseif ($process->type == 2) {
                if ($process->users->count() == $approval->approvalusers->where('status', 1)->count()) {
                    $approval->update([
                        'status' => 2
                    ]);

                    $newprocess = $workflow->activeprocesses->where('id', '<>', $assessment->current_steps)->where('order', '>', $process->order)->first();

                    if ($newprocess) {
                        $assessment_approval = AssessmentApproval::create([
                            'process_id' => $newprocess->id,
                            'assessment_id' => $assessment->id,
                            'status' => 1,
                            'type' => 0,
                        ]);

                        $this->insertUser($newprocess, $assessment_approval);

                        $assessment->update([
                            'current_steps' => $newprocess->id,
                        ]);
                        //send emails
                        $processUserIds = ProcessUser::where('process_id', $assessment->current_steps)->pluck('attachuser_id', 'attachuser_id');

                        if ($processUserIds) {
                            $processUsers = User::whereIn('id', $processUserIds)->get();
                            foreach ($processUsers as $processUser) {
                                Mail::to($processUser->email)->queue(new WaitingForApproval($processUser, $assessment_approval->id));
                            }
                        }
                        //send emails
                    } else {
                        $assessment->update([
                            'status' => 2,
                        ]);

                        //if approved send admin to approved message
                        if ($admin_users) {
                            $adminUsers = User::whereIn('id', $admin_users)->get();
                            foreach ($adminUsers as $adminUser) {
                                Mail::to($adminUser->email)->queue(new approvalSuccessToAdmin($adminUser));
                            }
                        }
                        //send emails
                    }
                }
            } else {
                if ($approval->approvalusers->where('status', 1)->count() == $process->minimum_no) {
                    $approval->update([
                        'status' => 2
                    ]);

                    $newprocess = $workflow->activeprocesses->where('id', '<>', $assessment->current_steps)->where('order', '>', $process->order)->first();

                    if ($newprocess) {
                        $assessment_approval = AssessmentApproval::create([
                            'process_id' => $newprocess->id,
                            'assessment_id' => $assessment->id,
                            'status' => 1,
                            'type' => 0,
                        ]);

                        $this->insertUser($newprocess, $assessment_approval);

                        $assessment->update([
                            'current_steps' => $newprocess->id,
                        ]);
                        //send emails
                        $processUserIds = ProcessUser::where('process_id', $assessment->current_steps)->pluck('attachuser_id', 'attachuser_id');

                        if ($processUserIds) {
                            $processUsers = User::whereIn('id', $processUserIds)->get();
                            foreach ($processUsers as $processUser) {
                                Mail::to($processUser->email)->queue(new WaitingForApproval($processUser, $assessment_approval->id));
                            }
                        }
                        //send emails
                    } else {
                        $assessment->update([
                            'status' => 2,
                        ]);

                        //if approved send admin to approved message
                        if ($admin_users) {
                            $adminUsers = User::whereIn('id', $admin_users)->get();
                            foreach ($adminUsers as $adminUser) {
                                Mail::to($adminUser->email)->queue(new approvalSuccessToAdmin($adminUser));
                            }
                        }
                        //send emails
                    }
                }
            }

            Session::flash('success', 'The Pending Assessment has been approved');

            return redirect()->route('client.assessments.approvelist', $subdomain);
        }
        // for rejection
        if ($request->submit === 'rejected') {
            $reject = AssessmentApproval::find($id);
            $assessment = $reject->assessment;
            $process = $assessment->currentstep;
            $workflow = $assessment->workflow;
            $admin_roles = Role::where('name', 'admin')->pluck('id', 'id');
            $admin_users = User::where('client_id', Auth::user()->client_id)->whereIn('role_id', $admin_roles)->pluck('id', 'id');

            //Authenticate User
            $processUserIds = ProcessUser::where('process_id', $assessment->current_steps)->pluck('attachuser_id', 'attachuser_id')->all();
            if (!in_array(Auth::user()->id, $processUserIds)) {
                return view('error.client-unauthorised', compact('subdomain'));
            }
            //Check previous submit or not
            $checkSubmit = AssessmentApprovalUser::where('user_id', Auth::user()->id)->where('assessment_approval_id', $id)->first();
            if ($checkSubmit !=null) {
                Session::flash('warning', 'You are already submitted your Opinion');
                return redirect()->back();
            }

            AssessmentApprovalUser::create([
                'assessment_approval_id' => $id,
                'user_id' => Auth::user()->id,
                'status' => 2,
                'note' => $request->get('note'),
                'ip' => $request->ip(),
            ]);

            if ($process->type == 1) {

                $reject->update([
                    'status' => 3
                ]);

                //'PROCESS_NOT_COMPLETE_TYPES' =>
                // [1 => 'Return to previous step if not complete', 2 => 'Proceed to next step', 3 => 'Stop']

                if ($process->process_type == 1) {

                    $newprocess = $workflow->activeprocesses->where('id', '<>', $assessment->current_steps)->where('order', $process->order - 1)->first();

                    if ($newprocess) {
                        $assessment_approval = AssessmentApproval::create([
                            'process_id' => $newprocess->id,
                            'assessment_id' => $assessment->id,
                            'status' => 1,
                            'type' => 1,
                        ]);

                        $this->insertUser($newprocess, $assessment_approval);

                        $assessment->update([
                            'current_steps' => $newprocess->id,
                        ]);

                        //send emails
                        $processUserIds = ProcessUser::where('process_id', $assessment->current_steps)->pluck('attachuser_id', 'attachuser_id');

                        if ($processUserIds) {
                            $processUsers = User::whereIn('id', $processUserIds)->get();
                            foreach ($processUsers as $processUser) {
                                Mail::to($processUser->email)->queue(new WaitingForApproval($processUser, $assessment_approval->id));
                            }
                        }
                        //send emails

                    } else {
                        $assessment->update([
                            'status' => 3,
                        ]);

                        //if rejected send admin to rejection message
                        if ($admin_users) {
                            $adminUsers = User::whereIn('id', $admin_users)->get();
                            foreach ($adminUsers as $adminUser) {
                                Mail::to($adminUser->email)->queue(new approvalRejectToAdmin($adminUser));
                            }
                        }
                        //send emails
                    }
                } else if ($process->process_type == 2) {

                    $newprocess = $workflow->activeprocesses->where('id', '<>', $assessment->current_steps)->where('order', '>', $process->order)->first();

                    if ($newprocess) {
                        $assessment_approval = AssessmentApproval::create([
                            'process_id' => $newprocess->id,
                            'assessment_id' => $assessment->id,
                            'status' => 1,
                            'type' => 1,
                        ]);

                        $this->insertUser($newprocess, $assessment_approval);

                        $assessment->update([
                            'current_steps' => $newprocess->id,
                        ]);

                        //send emails
                        $processUserIds = ProcessUser::where('process_id', $assessment->current_steps)->pluck('attachuser_id', 'attachuser_id');

                        if ($processUserIds) {
                            $processUsers = User::whereIn('id', $processUserIds)->get();
                            foreach ($processUsers as $processUser) {
                                Mail::to($processUser->email)->queue(new WaitingForApproval($processUser, $assessment_approval->id));
                            }
                        }
                        //send emails

                    } else {
                        $assessment->update([
                            'status' => 3,
                        ]);

                        //if rejected send admin to rejection message
                        if ($admin_users) {
                            $adminUsers = User::whereIn('id', $admin_users)->get();
                            foreach ($adminUsers as $adminUser) {
                                Mail::to($adminUser->email)->queue(new approvalRejectToAdmin($adminUser));
                            }
                        }
                        //send emails
                    }
                } else {
                    $assessment->update([
                        'status' => 3,
                    ]);

                    //if rejected send admin to rejection message
                    if ($admin_users) {
                        $adminUsers = User::whereIn('id', $admin_users)->get();
                        foreach ($adminUsers as $adminUser) {
                            Mail::to($adminUser->email)->queue(new approvalRejectToAdmin($adminUser));
                        }
                    }
                    //send emails
                }
            } elseif ($process->type == 2) {

                $reject->update([
                    'status' => 3
                ]);

                if ($process->process_type == 1) {

                    $newprocess = $workflow->activeprocesses->where('id', '<>', $assessment->current_steps)->where('order', $process->order - 1)->first();

                    if ($newprocess) {
                        $assessment_approval = AssessmentApproval::create([
                            'process_id' => $newprocess->id,
                            'assessment_id' => $assessment->id,
                            'status' => 1,
                            'type' => 1,
                        ]);

                        $this->insertUser($newprocess, $assessment_approval);

                        $assessment->update([
                            'current_steps' => $newprocess->id,
                        ]);
                        //send emails
                        $processUserIds = ProcessUser::where('process_id', $assessment->current_steps)->pluck('attachuser_id', 'attachuser_id');

                        if ($processUserIds) {
                            $processUsers = User::whereIn('id', $processUserIds)->get();
                            foreach ($processUsers as $processUser) {
                                Mail::to($processUser->email)->queue(new WaitingForApproval($processUser, $assessment_approval->id));
                            }
                        }
                        //send emails
                    } else {
                        $assessment->update([
                            'status' => 3,
                        ]);

                        //if rejected send admin to rejection message
                        if ($admin_users) {
                            $adminUsers = User::whereIn('id', $admin_users)->get();
                            foreach ($adminUsers as $adminUser) {
                                Mail::to($adminUser->email)->queue(new approvalRejectToAdmin($adminUser));
                            }
                        }
                        //send emails
                    }
                } else if ($process->process_type == 2) {

                    $newprocess = $workflow->activeprocesses->where('id', '<>', $assessment->current_steps)->where('order', '>', $process->order)->first();

                    if ($newprocess) {
                        $assessment_approval = AssessmentApproval::create([
                            'process_id' => $newprocess->id,
                            'assessment_id' => $assessment->id,
                            'status' => 1,
                            'type' => 1,
                        ]);

                        $this->insertUser($newprocess, $assessment_approval);

                        $assessment->update([
                            'current_steps' => $newprocess->id,
                        ]);
                        //send emails
                        $processUserIds = ProcessUser::where('process_id', $assessment->current_steps)->pluck('attachuser_id', 'attachuser_id');

                        if ($processUserIds) {
                            $processUsers = User::whereIn('id', $processUserIds)->get();
                            foreach ($processUsers as $processUser) {
                                Mail::to($processUser->email)->queue(new WaitingForApproval($processUser, $assessment_approval->id));
                            }
                        }
                        //send emails
                    } else {
                        $assessment->update([
                            'status' => 3,
                        ]);

                        //if rejected send admin to rejection message
                        if ($admin_users) {
                            $adminUsers = User::whereIn('id', $admin_users)->get();
                            foreach ($adminUsers as $adminUser) {
                                Mail::to($adminUser->email)->queue(new approvalRejectToAdmin($adminUser));
                            }
                        }
                        //send emails
                    }
                } else {
                    $assessment->update([
                        'status' => 3,
                    ]);

                    //if rejected send admin to rejection message
                    if ($admin_users) {
                        $adminUsers = User::whereIn('id', $admin_users)->get();
                        foreach ($adminUsers as $adminUser) {
                            Mail::to($adminUser->email)->queue(new approvalRejectToAdmin($adminUser));
                        }
                    }
                    //send emails
                }
            } else {

                if (($process->users->count() - $reject->approvalusers->where('status', 2)->count()) < $process->minimum_no) {

                    $reject->update([
                        'status' => 3
                    ]);

                    if ($process->process_type == 1) {

                        $newprocess = $workflow->activeprocesses->where('id', '<>', $assessment->current_steps)->where('order', $process->order - 1)->first();

                        if ($newprocess) {
                            $assessment_approval = AssessmentApproval::create([
                                'process_id' => $newprocess->id,
                                'assessment_id' => $assessment->id,
                                'status' => 1,
                                'type' => 1,
                            ]);

                            $this->insertUser($newprocess, $assessment_approval);

                            $assessment->update([
                                'current_steps' => $newprocess->id,
                            ]);
                            //send emails
                            $processUserIds = ProcessUser::where('process_id', $assessment->current_steps)->pluck('attachuser_id', 'attachuser_id');

                            if ($processUserIds) {
                                $processUsers = User::whereIn('id', $processUserIds)->get();
                                foreach ($processUsers as $processUser) {
                                    Mail::to($processUser->email)->queue(new WaitingForApproval($processUser, $assessment_approval->id));
                                }
                            }
                            //send emails
                        } else {
                            $assessment->update([
                                'status' => 3,
                            ]);

                            //if rejected send admin to rejection message
                            if ($admin_users) {
                                $adminUsers = User::whereIn('id', $admin_users)->get();
                                foreach ($adminUsers as $adminUser) {
                                    Mail::to($adminUser->email)->queue(new approvalRejectToAdmin($adminUser));
                                }
                            }
                            //send emails
                        }
                    } else if ($process->process_type == 2) {

                        $newprocess = $workflow->activeprocesses->where('id', '<>', $assessment->current_steps)->where('order', '>', $process->order)->first();

                        if ($newprocess) {
                            $assessment_approval = AssessmentApproval::create([
                                'process_id' => $newprocess->id,
                                'assessment_id' => $assessment->id,
                                'status' => 1,
                                'type' => 1,
                            ]);

                            $this->insertUser($newprocess, $assessment_approval);

                            $assessment->update([
                                'current_steps' => $newprocess->id,
                            ]);
                            //send emails
                            $processUserIds = ProcessUser::where('process_id', $assessment->current_steps)->pluck('attachuser_id', 'attachuser_id');

                            if ($processUserIds) {
                                $processUsers = User::whereIn('id', $processUserIds)->get();
                                foreach ($processUsers as $processUser) {
                                    Mail::to($processUser->email)->queue(new WaitingForApproval($processUser, $assessment_approval->id));
                                }
                            }
                            //send emails
                        } else {
                            $assessment->update([
                                'status' => 3,
                            ]);

                            //if rejected send admin to rejection message
                            if ($admin_users) {
                                $adminUsers = User::whereIn('id', $admin_users)->get();
                                foreach ($adminUsers as $adminUser) {
                                    Mail::to($adminUser->email)->queue(new approvalRejectToAdmin($adminUser));
                                }
                            }
                            //send emails
                        }
                    } else {
                        $assessment->update([
                            'status' => 3,
                        ]);

                        //if rejected send admin to rejection message
                        if ($admin_users) {
                            $adminUsers = User::whereIn('id', $admin_users)->get();
                            foreach ($adminUsers as $adminUser) {
                                Mail::to($adminUser->email)->queue(new approvalRejectToAdmin($adminUser));
                            }
                        }
                        //send emails
                    }
                }
            }

            Session::flash('success', 'The Pending Assessment has been reject');

            return redirect()->route('client.assessments.rejectlist', $subdomain);
        }
    }

//approvalreject store end

    private function insertUser($newprocess, $assessment_approval)
    {
        foreach ($newprocess->users as $user) {
            AssessmentApprovalUserArchive::create([
                'assessment_approval_id' => $assessment_approval->id,
                'user_id' => $user->attachuser_id,
            ]);
        }
    }


    public function index($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assessments-read'])) {

            $assets = [];

            $assessments = Assessment::whereHas('asset', function ($query) {
                $query->where('client_id', Auth::user()->client_id);
            });

            if ($request->get('workflow')) {
                $assessments->where('workflow_id', $request->get('workflow'));
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

            $assessments = $assessments->where('status', '>', 0)->orderBy('created_at', 'DESC')->with('asset', 'workflow', 'vendor')->paginate(50);

            $workflows = Workflow::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $vendors = VendorInfo::where('status', 1)->withTrashed()->orderBy('name', 'ASC')->pluck('name', 'id')->all();
            $assets = Asset::where([['status', 1], ['user_id', Auth::user()->id]])->whereHas('assessments')->orderBy('title', 'ASC')->pluck('title', 'id')->all();

            return view('client.assessments.index', compact('assessments', 'subdomain', 'workflows', 'vendors', 'assets'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    //insert New User date into assessment_approval_user_archives table

    public function timeline($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assessments-read'])) {
            $assessment = Assessment::find($id);
            return view('client.assessments.timeline', compact('assessment', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }
}
