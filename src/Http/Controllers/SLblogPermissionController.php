<?php

namespace Simoja\SLblog\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Simoja\SLblog\Facades\SLblog;

class SLblogPermissionController extends Controller
{
    public function browse()
    {
        //Need To change After
        return view('slblog::user.browse');
    }
    public function roles()
    {
        return view('slblog::role.browse');
    }
    public function users()
    {
        return view('slblog::user.browse');
    }
    public function create()
    {
        return view('slblog::add-edit');
    }
}
