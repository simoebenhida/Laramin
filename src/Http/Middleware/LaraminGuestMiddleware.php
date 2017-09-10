<?php

namespace Simoja\Laramin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Simoja\Laramin\Facades\Laramin;

class LaraminGuestMiddleware
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
             return redirect()->route('laramin.dashboard');
            }
        return $next($request);
    }
}
