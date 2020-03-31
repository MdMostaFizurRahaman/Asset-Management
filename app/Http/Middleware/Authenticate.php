<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware {

    protected $guards;

    public function handle($request, Closure $next, ...$guards) {
        $this->guards = $guards;
        return parent::handle($request, $next, ...$guards);
    }

    protected function redirectTo($request) {
        if (!$request->expectsJson()) {
            $subdomain = Route::input('subdomain');
            if (array_first($this->guards) === 'admin') {
                return route('admin.login');
            } else if (array_first($this->guards) === 'vendor') {
                return route('vendor.login');
            } else if (array_first($this->guards) == 'vendor-api') {
                return response()->json(
                    [
                        'error' => 900,
                        'errorMsg' => 'Unauthorized.',
                    ]
                );
            }else {
                return route('client.login', $subdomain);
            }

            return route('login');
        }
    }

}
