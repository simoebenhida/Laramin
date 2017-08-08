<?php

namespace Simoja\SLblog\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SLBlogHomeController extends Controller
{
    public function index()
    {
    	return redirect()->route('slblog.dashboard');
    }
    public function dashboard()
    {
    	return view('slblog::dashboard.index');
    }
}