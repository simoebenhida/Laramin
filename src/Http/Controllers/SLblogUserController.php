<?php

namespace Simoja\SLblog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Simoja\SLblog\Facades\SLblog;

class SLblogUserController extends Controller
{
    public function update()
    {
        $userByID = SLblog::model('User')::find(request()->id);
        $userByID->update(collect(request()->all())->only([
                                                                                                                'name',
                                                                                                                'email'
                                                                                                                 ])->toArray());
        //Attach Or Detach Role
        if(request()->role)
        {
                     $role = SLblog::model('Role')->where('name',request()->role)->first();
                     $userByID->detachRole($role);
        }
        // $user->attachRole(2);
        return response()->json(['user' => $userByID,'users' => SLblog::model('User')->all()]);
    }
}
