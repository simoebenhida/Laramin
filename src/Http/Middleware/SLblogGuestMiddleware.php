<?php

namespace Simoja\SLblog\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Simoja\SLblog\Facades\SLblog;

class SLblogGuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         if (Auth::check()) {
             return redirect()->route('slblog.dashboard');
            }
        return $next($request);
    }
}
