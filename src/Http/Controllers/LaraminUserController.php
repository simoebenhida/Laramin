<?php

namespace Simoja\Laramin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Simoja\Laramin\Facades\Laramin;

class LaraminUserController extends Controller
{
    public function validation(Request $request, $update = null)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$update
        ]);
    }

    public function store(Request $request)
    {
        if (! $this->can('create-users', request()->auth_id)) {
            abort(404);
        }
        $this->validation($request);
        $user = Laramin::model('User')->create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => bcrypt(config('laramin.password'))
        ]);
        $user->attachRole(request()->role);
        return response()->json(['created' => true,'user' => $user]);
    }

    public function update(Request $request)
    {
        if (! $this->can('update-users', request()->auth_id)) {
            abort(404);
        }
        $this->validation($request, $request->id);
        $user = Laramin::model('User')::find(request()->id);
        $user->update(collect(request()->all())->except(['role','id'])->toArray());
        $role = $user->roles()->first()->name;

        if (request()->role !== $role) {
            $user->detachRole(request()->oldRole);
            $user->attachRole(request()->role);
        }

        return response()->json(['user' => $user,'users' => Laramin::model('User')->all()]);
    }

    public function destroy($auth, $id)
    {
        if (! $this->can('delete-users', $auth)) {
            abort(404);
        }
        $user = Laramin::model('User')::find($id);
        $user->delete();
        return response()->json(['destroyed' => true]);
    }

    public function Profileedit()
    {
        return view('laramin::profile.edit');
    }

    public function Profileupdate(Request $request)
    {
        $user = auth()->user();
        $this->validation($request, auth()->user()->id);
        $user->update(collect($request->all())->except(['avatar'])->toArray());
        if ($request->avatar) {
            $extension = $request->avatar->getClientOriginalExtension();
            $filename = auth()->id().'.'.$extension;
            $path = $request->avatar->storeAs('public/avatar', $filename);
            $user->avatar = $filename;
            $user->update();
        }
        Session::flash($this->flashname, $this->SessionMessage("Your Profile Has Been Succesfully Updated", 'success'));
        return redirect()->back();
    }

    public function editOwnPassword(Request $request)
    {
        $user = Laramin::model('User')::find($request->auth_id);
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);
        if (Hash::check($request->old_password, $user->password)) {
            // dd(bcrypt($request->password));
            $user->password = bcrypt($request->password);
            $user->update();
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }
}
