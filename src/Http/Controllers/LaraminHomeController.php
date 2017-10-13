<?php

namespace Simoja\Laramin\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;

class LaraminHomeController extends Controller
{
    public function index()
    {
    	return redirect()->route('laramin.dashboard');
    }
    public function dashboard()
    {
    	return view('laramin::dashboard.index');
    }
    public function profile()
    {
        return view('laramin::profile.index');
    }
    public function edit()
    {
        return view('laramin::profile.edit');
    }
}
