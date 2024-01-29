<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Sync1S
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->server->get('PHP_AUTH_USER');
        $pass = $request->server->get('PHP_AUTH_PW');

        /* check credentials to auth*/

        Log::channel('daily')->info('sync - login OK');
        return $next($request);
    }
}
