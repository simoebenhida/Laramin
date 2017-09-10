<?php

namespace Simoja\Laramin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Simoja\Laramin\Facades\Laramin;

class LaraminPermissionMiddleware
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
        //check Request URL
        $url = collect(Laramin_get_active_menu());
        if($url->first()) {
            $current = $url->first();
            if($current == 'models')
            {
                $current = $url[1];
            }
        $name =Str::plural($current);
        $permission = "read-{$name}";
        if(Auth::user()->can($permission))
        {
            return $next($request);
        }
        else {
        return redirect(route('laramin.dashboard'));
        }
    }else {
        return redirect(route('laramin.dashboard'));
    }

        //check User Permission
        // if (!Auth::guest()) {
        //     $user = Laramin::model('User')->find(Auth::id());
        //     return $next($request);
        // }
        // return redirect(route('slblog.login'));
    }
}
