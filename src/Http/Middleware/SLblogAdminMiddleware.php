<?php

namespace Simoja\SLblog\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Simoja\SLblog\Facades\SLblog;

class SLblogAdminMiddleware
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
            $user = SLblog::model('User')->find(Auth::id());
            // $createPost = SLblog::model('Permission')->find(1);
            // $role = SLblog::model('Role')->find(1);
            // $user->attachPermission($createPost);
            // $user->detachRole($role);
            // $user->attachRole($role);
            // dd($user->hasRole('superadministrator'));
            // return $user->hasPermission('browse_admin') ? $next($request) : redirect('/');
            return $next($request);
        }
        return redirect(route('slblog.login'));
    }
}
