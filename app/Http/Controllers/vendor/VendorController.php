<?php

namespace App\Http\Controllers\vendor;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class VendorController extends Controller {

    public function __construct() {
        $this->middleware('auth:vendor');
    }

    public function dashboard() {
        return view('vendor.vendor');
    }

    public function password() {
        return view('vendor.changePassword');
    }

    public function passwordUpdate(Request $request) {
        $messages = [
            'old_password.required' => 'Current password is required',
            'old_password.old_password' => 'Current password is wrong',
            'password.required' => 'New Password is required',
            'password.confirmed' => 'New Passwords does not match',
            'password.min' => 'New Password must be at least 6 char long',
            'password.max' => 'New Password can be maximum 200 char long',
        ];

        $this->validate($request, [
            'old_password' => 'required|old_password:' . Auth::guard('vendor')->user()->password,
            'password' => 'required|confirmed|min:6|max:255',
                ], $messages);

        $vendor = Auth::guard('vendor')->user();

        $vendor['password'] = bcrypt($request->get('password'));

        $vendor->save();

        Session::flash('success', 'Your password has been updated');

        return redirect()->route('vendor.editPassword');
    }

}
