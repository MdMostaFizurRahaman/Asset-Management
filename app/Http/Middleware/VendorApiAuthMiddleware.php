<?php

namespace App\Http\Middleware;

use Closure;

class VendorApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('API_DEBUG')) {
            return $next($request);
        } else if ($request->get('authentication') && $request->get('authentication') == env('VENDOR_API_AUTHENTICATION')) {
            return $next($request);
        } else {
            $returnData = array();
            $returnData['error'] = 1;
            $returnData['errorMsg'] = 'Api Authentication failed';
            return response()->json($returnData);
        }
    }
}
