<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NovaDateSyncDisable
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $inputKey = '_retrieved_at';

        if ($request->has($inputKey)) {
            $request->merge([
                $inputKey => now()->timestamp,
            ]);
        }

        return $next($request);
    }
}
