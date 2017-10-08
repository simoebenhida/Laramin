<?php

namespace Simoja\Laramin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Simoja\Laramin\Facades\Laramin;

class LaraminRoleController extends Controller
{
    public function validation($request,$update = null)
    {
        $this->validate($request,[
            'name' => 'required|unique:roles,name,'.$update,
            'display_name' => 'required|alpha|unique:roles,display_name,'.$update,
            'description' => 'required'
        ]);
    }
    public function store(Request $request)
    {
        if(! $this->UserCan(request()->auth_id,'create-roles'))
        {
            abort(404);
        }
        $this->validation($request);
        $role = Laramin::model('Role')->create(collect(request()->all())->except('auth_id')->toArray());
        return response()->json($role);
    }

    public function getAssignPermission()
    {
        if(! $this->UserCan(request()->key,'update-roles')){
            abort(404);
        }
        $role = Laramin::model('Role')::find(request()->id);
        return response()->json(Laramin::getModelPermission($role));
    }

    public function assignPermission()
    {
        if(! $this->UserCan(request()->auth_id,'update-roles')){
            abort(404);
        }
        $role = Laramin::model('Role')::find(request()->id);

        $input = collect(request()->inputs);
        $input->each(function($item,$key) use($role) {
                    collect($item)->each(function($value,$index) use($key,$role) {
                            $name = $index.'-'.Str::plural(strtolower($key));
                           $permission = Laramin::model('Permission')->where('name',$name)->first();
                            if($permission)
                            {
                           $permission = $permission->toArray();
                            if($value)
                            {
                                if(! $role->hasPermission($permission))
                                {
                                          $role->attachPermission($permission);
                                }
                            }else {
                                         $role->detachPermission($permission);
                            }
                            }
                    });
        });
        return response()->json(Laramin::model('Role')->all());
    }

    public function update(Request $request)
    {
        if(! $this->UserCan(request()->auth_id,'update-roles')){
                abort(404);
        }
        $this->validation($request,request()->id);
        $role = Laramin::model('Role')::find(request()->id);
        $role->update(collect(request()->all())->except(['id','auth_id'])->toArray());
        return response()->json($role);
    }


    public function destroy($auth,$id)
    {
        if(! $this->UserCan($auth,'delete-roles')){
                abort(404);
        }
        $role = Laramin::model('Role')::find($id);
        $role->delete();
        return response()->json(true);
    }
}
