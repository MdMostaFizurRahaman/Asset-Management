<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorHandlerController extends Controller
{
    public function admin404(){
        return view('errors.admin-404');
    }

    public function client404($subdomain){
        return view('errors.client-404',compact('subdomain'));
    }

    public function vendor404(){
        return view('errors.vendor-404');
    }
}
