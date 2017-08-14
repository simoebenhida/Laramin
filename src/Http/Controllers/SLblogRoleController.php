<?php

namespace Simoja\SLblog\Http\Controllers;

use App\DataInfo;
use App\DataType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Simoja\SLblog\Facades\SLblog;

class SLblogRoleController extends Controller
{
    public function store()
    {
                 $newRole = SLblog::model('Role')->create(request()->all());
                 return response()->json($newRole);
    }


}
