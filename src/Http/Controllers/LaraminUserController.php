<?php

namespace Simoja\Laramin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Simoja\Laramin\Facades\Laramin;

class LaraminUserController extends Controller
{

    public function validation(Request $request,$update = null)
    {
         $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$update
        ]);
    }

    public function store(Request $request)
    {
        if(! $this->UserCan(request()->auth_id,'create-users')){
            abort(404);
        }
        $this->validation($request);
        $user = Laramin::model('User')->create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => bcrypt(config('Laramin.password'))
        ]);
        $user->attachRole(request()->role);
        return response()->json(['created' => true,'user' => $user]);
    }

    public function update(Request $request)
    {
        if(! $this->UserCan(request()->auth_id,'update-users')){
            abort(404);
        }
        $this->validation($request,$request->id);
        $user = Laramin::model('User')::find(request()->id);
        $user->update(collect(request()->all())->except(['role','id'])->toArray());
        $role = $user->roles()->first()->name;

        if (request()->role !== $role) {
            $user->detachRole(request()->oldRole);
            $user->attachRole(request()->role);
        }

        return response()->json(['user' => $user,'users' => Laramin::model('User')->all()]);
    }

    public function destroy($auth,$id)
    {
        if(! $this->UserCan($auth,'delete-users')){
            abort(404);
        }
        $user = Laramin::model('User')::find($id);
        $user->delete();
        return response()->json(['destroyed' => true]);
    }

    public function editOwnUser(Request $request)
    {
        $this->valiation($request,auth()->user()->id);
    }
    public function editOwnPassword(Request $request)
    {
        $user = Laramin::model('User')::find($request->auth_id);
        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->password);
            return response()->json(['status' => true]);
        }else {
            return response()->json(['status' => false]);
        }
    }
}
