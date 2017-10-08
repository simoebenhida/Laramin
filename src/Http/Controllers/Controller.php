<?php

namespace Simoja\Laramin\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Simoja\Laramin\Facades\Laramin;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getSlug(Request $request)
    {
         return explode('.', $request->route()->getName())[1];
    }
    public function UserCan($user = null,$permission = null)
    {
        if($permission == null || $user == null)
        {
            return false;
        }
        $user = Laramin::model('User')::find($user);
        return $user->can($permission);
    }
}
