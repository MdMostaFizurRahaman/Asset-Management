<?php

namespace App\Http\Controllers\client;

use App\Assessment;
use App\Process;
use App\Workflow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProcessController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index($subdomain, $workflow)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-processes-read'])) {
            $in_progress_check = Assessment::where(['workflow_id' => $workflow, 'status' => 1])->count();

            Session::forget('warning');
            if ($in_progress_check > 0) {
                Session::flash('warning', 'This Workflow may be currently assign in assessment. So you can\'t edit now.');
            }
            $workflow = Workflow::find($workflow);
            return view('client.processes.index', compact('workflow', 'subdomain','in_progress_check'));

        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain)
    {
        //
    }

    public function store($subdomain, $workflow, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-processes-create'])) {

            $in_progress_check = Assessment::where(['workflow_id' => $workflow, 'status' => 1])->count();
            if ($in_progress_check > 0) {
                Session::flash('warning', 'This Workflow may be currently assign in assessment. So you can\'t edit now.');
                return redirect()->back();
            }

            $messages = [
                'process_type.required' => 'Action For Not Complete (Rejected) field is required.',
                'minimum_no.required_if' => 'The minimum no user field is required when you select Minimum no. of user can approve option.',
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('processes')->where('client_id', Auth::user()->client_id)->where('workflow_id', $workflow)->whereNull('deleted_at'),
                ],
                'type' => 'required',
                'minimum_no' => 'sometimes|nullable|required_if:type,3|integer',
                'process_type' => 'required',
                'order' => [
                    'required',
                    Rule::unique('processes')->where('client_id', Auth::user()->client_id)->where('workflow_id', $workflow)->whereNull('deleted_at'),
                    'integer',
                ],


            ], $messages);

            $input = $request->all();

            $input['user_id'] = Auth::user()->id;
            $input['client_id'] = Auth::user()->client_id;
            $input['workflow_id'] = $workflow;

            if (!$request->get('minimum_no')) {
                $input['minimum_no'] = 0;
            }

            Process::create($input);

            Session::flash('success', 'The Process has been created');

            return redirect()->route('client.processes.index', [$subdomain, $workflow]);
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
    public function edit($subdomain, $workflow, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-processes-update'])) {
            $process = Process::find($id);
            return view('client.processes.edit', compact('process', 'subdomain'));
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
    public function update($subdomain, $workflow, $id, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-processes-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('processes')->where('client_id', Auth::user()->client_id)->where('workflow_id', $workflow)->whereNull('deleted_at')->ignore($id),
                ],
                'type' => 'required',
                'minimum_no' => 'sometimes|nullable|required_if:type,3|integer',
                'process_type' => 'required',
                'order' => [
                    'required',
                    Rule::unique('processes')->where('client_id', Auth::user()->client_id)->where('workflow_id', $workflow)->whereNull('deleted_at')->ignore($id),
                    'integer',
                ],
            ];

            $messages = [
                'process_type.required' => 'Action For Not Complete (Rejected) field is required.',
                'minimum_no.required_if' => 'The minimum no user field is required when you select Minimum no. of user can approve option.',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $process = Process::find($id);
            $process->update($input);

            Session::flash('success', 'The Process has been updated');

            return redirect()->route('client.processes.index', [$subdomain, $workflow]);
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
    public function destroy($subdomain, $workflow, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-processes-delete'])) {
            $process = Process::find($id);

            $process->update([
                'user_id' => Auth::user()->id,
            ]);

            $process->delete();

            Session::flash('success', 'The Process has been deleted');

            return redirect()->route('client.processes.index', [$subdomain, $workflow]);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
