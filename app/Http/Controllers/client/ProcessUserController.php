<?php

namespace App\Http\Controllers\client;

use App\Process;
use App\ProcessUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ProcessUserController extends Controller {

    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index($subdomain, $id) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-processusers-read'])) {
            $process = Process::find($id);
            $users = User::where([['client_id', $process->client_id], ['status', 1]])->whereNotIn('id', $process->users->pluck('attachuser_id')->all())->pluck('name', 'id')->all();
            return view('client.processes.users', compact('process', 'subdomain', 'users'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain) {
    }

    public function store($subdomain, $id, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-process-user-create'])) {
            $messages = [
                    //
            ];

            $this->validate($request, [
                'attachuser_id' => 'required',
                    ], $messages);

            $input = $request->all();

            $input['user_id'] = Auth::user()->id;
            $input['process_id'] = $id;

            ProcessUser::create($input);

            Session::flash('success', 'The Process User has been created');

            return redirect()->route('client.processusers.index', [$subdomain, $id]);
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
        //
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, $process, $id) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-processusers-delete'])) {
            $user = ProcessUser::find($id);

            $user->update([
                'delete_user_id' => Auth::user()->id,
            ]);

            $user->delete();

            Session::flash('success', 'The Process User has been deleted');

            return redirect()->back();
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
