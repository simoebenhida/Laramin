<?php

namespace Simoja\SLblog\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SLBlogHomeController extends Controller
{
    public function index()
    {
    	return view('slblog::post.browse');
    }
}
