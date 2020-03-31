<?php

namespace App\Http\Controllers\client;

use App\Asset;
use App\AssetAssignLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function dashboard($subdomain)
    {
        return view('client.client', compact('subdomain'));
    }

    public function details($subdomain)
    {
        $client = Auth::user();
        return view('client.details', compact('subdomain', 'client'));
    }


    public function password($subdomain)
    {
        return view('client.changePassword', compact('subdomain'));
    }

    public function passwordUpdate($subdomain, Request $request)
    {
        $messages = [
            'old_password.required' => 'Current password is required',
            'old_password.old_password' => 'Current password is wrong',
            'password.required' => 'New Password is required',
            'password.confirmed' => 'New Passwords does not match',
            'password.min' => 'New Password must be at least 6 char long',
            'password.max' => 'New Password can be maximum 200 char long',
        ];

        $this->validate($request, [
            'old_password' => 'required|old_password:' . Auth::user()->password,
            'password' => 'required|confirmed|min:6|max:255',
        ], $messages);

        $client = Auth::user();

        $client['password'] = bcrypt($request->get('password'));

        $client->save();

        Session::flash('success', 'Your password has been updated');

        return redirect()->route('client.editPassword', $subdomain);
    }

    // Asset Related Task

    public function assetedit($subdomain, $id)
    {
        $asset = Asset::findOrFail($id);
        if ($asset->assign_user == Auth::user()->id) {
            return view('client.asset-assign-user.returntostore', compact('asset', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function assetupdate($subdomain, $id, Request $request)
    {
        $asset = Asset::findOrFail($id);
        if ($asset->assign_user == Auth::user()->id) {
            $messages = [

            ];

            $this->validate($request, [
                'return_note' => 'required',
            ], $messages);

            $input['user_id'] = Auth::user()->id;
            $input['accept_reject_status'] = 3;
            $asset->update($input);

            //Asset Log
            $log['type'] = 6;
            $log['user_id'] = Auth::user()->id;
            $log['asset_id'] = $asset->id;
            $log['assign_user'] = $asset->assign_user;
            $log['accept_reject_status'] = 3;
            $log['is_return'] = 1;
            $log['store_id'] = $asset->store_id;
            $log['return_store_id'] = $asset->store_id;
            $log['note'] = $request->return_note;
            $assignLog = AssetAssignLog::create($log);

            Session::flash('success', 'The Asset has been Returned');
            return redirect()->route('client.details', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }


    public function assetacceptstore($subdomain, $id)
    {
        $asset = Asset::findOrFail($id);
        if ($asset->assign_user == Auth::user()->id) {

            $input['user_id'] = Auth::user()->id;
            $input['accept_reject_status'] = 1;
            $asset->update($input);

            //Asset Log
            $log['type'] = 4;
            $log['user_id'] = Auth::user()->id;
            $log['asset_id'] = $asset->id;
            $log['assign_user'] = $asset->assign_user;
            $log['accept_reject_status'] = 1;
            $log['store_id'] = $asset->store_id;
            $assignLog = AssetAssignLog::create($log);

            Session::flash('success', 'The Asset has been Accepted');
            return redirect()->route('client.details', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function assetreject($subdomain, $id)
    {
        $asset = Asset::findOrFail($id);
        if ($asset->assign_user == Auth::user()->id) {
            return view('client.asset-assign-user.assetareject', compact('asset', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function assetrejectstore($subdomain, $id, Request $request)
    {
        $asset = Asset::findOrFail($id);
        if ($asset->assign_user == Auth::user()->id) {
            $assign_user = $asset->assign_user;
            $messages = [

            ];

            $this->validate($request, [
                'reject_note' => 'required',
            ], $messages);

            $input['user_id'] = Auth::user()->id;
            $input['accept_reject_status'] = 0;
            $input['assign_user'] = 0;
            $asset->update($input);


            //Asset Log
            $log['type'] = 5;
            $log['user_id'] = Auth::user()->id;
            $log['asset_id'] = $asset->id;
            $log['assign_user'] = $assign_user;
            $log['accept_reject_status'] = 2;
            $log['store_id'] = $asset->store_id;
            $log['return_store_id'] = $asset->store_id;
            $log['note'] = $request->reject_note;
            $assignLog = AssetAssignLog::create($log);

            Session::flash('success', 'The Asset has been Rejected');
            return redirect()->route('client.details', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }
}
