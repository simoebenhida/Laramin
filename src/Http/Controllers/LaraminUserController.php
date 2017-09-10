<?php

namespace Simoja\Laramin\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Simoja\Laramin\Facades\Laramin;

class LaraminUserController extends Controller
{
    public function update()
    {
        $userByID = Laramin::model('User')::find(request()->id);
        $userByID->update(collect(request()->all())->only(['name','email'])->toArray());
        if (request()->role) {
            $userByID->detachRole(request()->oldRole);
            $userByID->attachRole(request()->role);
        }
        return response()->json(['user' => $userByID,'users' => Laramin::model('User')->all()]);
    }
    public function destroy($id)
    {
        $user = Laramin::model('User')::find($id);
        $user->delete();
        return response()->json(true);
    }
}
