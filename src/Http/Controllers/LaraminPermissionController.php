<?php

namespace Simoja\Laramin\Http\Controllers;
// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Simoja\Laramin\Facades\Laramin;

class LaraminPermissionController extends Controller
{
    public function browse()
    {
        //Need To change After
        return view('laramin::user.browse');
    }
    public function roles()
    {
        return view('laramin::role.browse');
    }
    public function users()
    {
        return view('laramin::user.browse');
    }
    public function create()
    {
        return view('laramin::add-edit');
    }
}
