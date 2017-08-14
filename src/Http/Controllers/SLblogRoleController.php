<?php

namespace Simoja\SLblog\Http\Controllers;

use App\DataInfo;
use App\DataType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Simoja\SLblog\Facades\SLblog;

class SLblogRoleController extends Controller
{
    public function store()
    {
                 $newRole = SLblog::model('Role')->create(request()->all());
                 return response()->json($newRole);
    }

    public function assignPermission()
    {
            $role = SLblog::model('Role')::find(request()->id);
            $input = collect(request()->inputs);
            $cool = collect([]);
            $input->each(function($item,$key) use($role,$cool) {
                        collect($item)->each(function($value,$index) use($key,$role,$cool) {
                                $name = $index.'-'.Str::plural(strtolower($key));
                                $cool->push($name);
                               $permission = SLblog::model('Permission')->where('name',$name)->first()->toArray();
                                if($value)
                                {
                                    if(! $role->hasPermission($permission))
                                    {
                                    $role->attachPermission($permission);
                                    }
                                }else {
                                    $role->detachPermission($permission);
                                }
                        });
            });
            // dd($cool);
    }
}
