<?php

namespace Simoja\Laramin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Simoja\Laramin\Facades\Laramin;

class LaraminAdminMiddleware
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
        if (!Auth::guest()) {
            $user = Laramin::model('User')->find(Auth::id());
            return $next($request);
        }
        return redirect(route('laramin.login'));
    }
}
