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

    protected $flashname = 'Laramin_Toast';

    public function getSlug(Request $request)
    {
        return explode('.', $request->route()->getName())[1];
    }

    public function can($permission = null, $userID)
    {
        if ($permission == null) {
            return false;
        }
        return Laramin::model('User')->find($userID)->can($permission);
    }

    public function SessionMessage($message, $type)
    {
        $infos = collect();
        $infos->put('message', $message);
        $infos->put('type', $type);
        $infos->put('title', ucfirst($type));
        return $infos->toJson();
    }
}
