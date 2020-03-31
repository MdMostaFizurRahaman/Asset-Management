<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (!config('app.debug')) {
            if ($this->isHttpException($exception)) {
                if ($exception->getStatusCode() == 404 || !config('app.debug')) {
                    $host = explode('.', \Request::getHttpHost());
                    $domain = array_first($host);
                    if ($domain === 'admin') {
                        return redirect()->route('admin.404');
                    } elseif ($domain === 'vendor') {
                        return redirect()->route('vendor.404');
                    } else {
                        return redirect()->route('client.404', compact('domain'));
                    }
                }
            } elseif ($exception instanceof \PDOException) {
                return response()->view('errors.500', [], 500);
            }
        }
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $guard = array_get($exception->guards(), 0);
        $host = explode('.', \Request::getHttpHost());
        $domain = array_first($host);
//        dd($domain);
        switch ($guard) {
            case 'admin':
                $login = 'admin.login';
                break;
            case 'web':
                $login = 'client.login';
                break;
            case 'vendor-api':
                $login = 'vendor-api';
                break;
            default:
                $login = 'vendor.login';
                break;
        }
        if ($login == 'admin.login') {
            return redirect()->guest(route($login));
        } elseif ($login == 'client.login') {
            return redirect()->guest(route($login, compact('domain')));
        } elseif ($login == 'vendor-api') {
            return response()->json(['error' => 900, 'errorMsg' => 'Unauthorized.']);
        } else {
            return redirect()->guest(route($login));
        }
    }
}
