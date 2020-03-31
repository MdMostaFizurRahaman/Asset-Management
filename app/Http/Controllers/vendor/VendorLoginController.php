<?php

namespace App\Http\Controllers\vendor;

use App\VendorInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:vendor', ['except' => ['logout']]);
    }

    public function showLogin()
    {
        return view('vendor.login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'username' => [
                'required',
                'regex:/^[a-zA-Z0-9]+@{1}[a-zA-Z0-9]+$/',
            ],
            'password' => 'required'
        ]);

        $user_arr = explode("@", $request->username);
        $vendor_info = VendorInfo::where('vendor_id', $user_arr[1])->first();
        if ($vendor_info) {
            // Attempt to log the user in
            if (Auth::guard('vendor')->attempt(['username' => $user_arr[0], 'password' => $request->password, 'vendor_info_id'=>$vendor_info->id,'status' => 1], $request->remember)) {
                // if successful, then redirect to their intended location
                return redirect()->intended(route('vendor.dashboard'));
            }

        }
        // if unsuccessful, then redirect back to the login with the form data
        $errors = ['username' => trans('auth.failed')];
        return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors($errors);
    }


    public function logout()
    {
        Auth::guard('vendor')->logout();
        return redirect()->route('vendor.login');
    }

}
