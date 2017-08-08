<?php
namespace Simoja\SLblog\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SLBlogDatabaseController extends Controller
{
    public function browse()
    {
    	return view('slblog::database.browse');
    }

    public function create()
    {
    	return view('slblog::database.add-edit');
    }

    public function store()
    {
    	dd('Fake');
    }
}
