<?php

namespace Simoja\Laramin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Simoja\Laramin\Facades\Laramin;

class LaraminRoleController extends Controller
{
    public function validation($request, $update = null)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $update,
            'display_name' => 'required|alpha|unique:roles,display_name,' . $update,
            'description' => 'required'
        ]);
    }

    public function store(Request $request)
    {
        if (!$this->can('create-roles', request()->auth_id)) {
            abort(404);
        }
        $this->validation($request);
        $role = Laramin::model('Role')->create(collect(request()->all())->except('auth_id')->toArray());
        return response()->json($role);
    }

    public function assignedPermission()
    {
        if (!$this->can('update-roles', request()->key)) {
            abort(404);
        }
        $role = Laramin::model('Role')::find(request()->id);
        return response()->json(Laramin::getModelPermission($role));
    }

    public function assignPermission()
    {
        if (!$this->can('update-roles', request()->auth_id)) {
            abort(404);
        }

        $role = Laramin::model('Role')::find(request()->id);

        collect(request()->permissions)->each(function ($item, $key) use ($role) {
            collect($item)->each(function ($value, $index) use ($key, $role) {
                $permission = Laramin::model('Permission')
                    ->where('name', $index . '-' . Str::plural(strtolower($key)))
                    ->first();
                $role->detachPermission($permission);
                if ($permission->exists() && $value) {
                    $role->attachPermission($permission);
                }
            });
        });

        return response()->json(Laramin::model('Role')->all());
    }

    public function update(Request $request)
    {
        if (!$this->can('update-roles', request()->auth_id)) {
            abort(404);
        }
        $this->validation($request, request()->id);

        $role = Laramin::model('Role')::find(request()->id)
            ->update(collect(request()->all())->except(['id', 'auth_id'])->toArray());

        return response()->json($role);
    }


    public function destroy($auth, $id)
    {
        if (!$this->can('delete-roles', $auth)) {
            abort(404);
        }

        Laramin::model('Role')::find($id)
            ->delete();

        return response()->json(true);
    }
}
