<?php

namespace App\Http\Controllers\client;

use App\Workflow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class WorkflowController extends Controller {

    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-workflows-read'])) {

            $workflows = Workflow::where('client_id', Auth::user()->client_id);

            if ($request->get('title')) {
                $workflows->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            $workflows = $workflows->orderBy('title', 'ASC')->paginate(50);

            return view('client.workflows.index', compact('workflows', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-workflows-create'])) {
            return view('client.workflows.create', compact('subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-workflows-create'])) {
            $messages = [
                    //
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('workflows')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                ],
                    ], $messages);

            $input = $request->all();

            $input['user_id'] = Auth::user()->id;
            $input['client_id'] = Auth::user()->client_id;

            $workflow = Workflow::create($input);

            Session::flash('success', 'The Workflow has been created');

            return redirect()->route('client.processes.index', [$subdomain, $workflow->id]);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, $id) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-workflows-update'])) {
            $workflow = Workflow::find($id);
            return view('client.workflows.edit', compact('workflow', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, Request $request, $id) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-workflows-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('workflows')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($id),
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

            $workflow = Workflow::find($id);
            $workflow->update($input);

            Session::flash('success', 'The Workflow has been updated');

            return redirect()->route('client.workflows.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, $id) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-workflows-delete'])) {
            $workflow = Workflow::find($id);

            $workflow->update([
                'user_id' => Auth::user()->id,
            ]);

            $workflow->delete();

            Session::flash('success', 'The Workflow has been deleted');

            return redirect()->route('client.workflows.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
