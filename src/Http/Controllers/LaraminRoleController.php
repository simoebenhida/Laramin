<?php

namespace Simoja\Laramin\Http\Controllers;

use App\DataInfo;
use App\DataType;
// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Simoja\Laramin\Facades\Laramin;

class LaraminRoleController extends Controller
{
    public function store()
    {
                 $newRole = Laramin::model('Role')->create(request()->all());
                 return response()->json($newRole);
    }

    public function assignPermission()
    {
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

    public function update()
    {
        $role = Laramin::model('Role')::find(request()->id);
        $role->update(request()->all());
        return response()->json($role);
    }

    public function getAssignPermission()
    {
        $role = Laramin::model('Role')::find(request()->id);
        return response()->json(Laramin::getModelPermission($role));
    }

    public function destroy($id)
    {
        //Add Find Or Fail
        $role = Laramin::model('Role')::find($id);
        $role->delete();
        return response()->json(true);
    }
}
