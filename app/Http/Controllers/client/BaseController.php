<?php

namespace App\Http\Controllers\client;

use App\AssessmentApproval;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller {

    public function __construct() {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });

        $pendingassessments = AssessmentApproval::where('status', 0)->whereHas('process.users', function($query) {
                    $query->where('attachuser_id', $this->user->id);
                })->count();

        View::share('pendingassessments', $pendingassessments);
    }

}
