<?php

namespace Simoja\Laramin\Traits;

use Simoja\Laramin\Facades\Laramin;
use Simoja\Laramin\Helpers\DatabaseType;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Simoja\Laramin\Models\Permission;
use Illuminate\Support\Facades\Schema;

trait LaraminDatabase
{
    public function databaseStore($request)
    {
        $type = $this->dataType($request);
        $this->dataInfos($request, $type->id);
    }

    public function dataType($request)
    {
        return Laramin::model('DataType')->create([
            'name' => ucfirst($request->name),
            'model' => ucfirst($request->name),
            'menu' => $request->menu,
            'slug' => $request->slug
        ]);
    }

    public function dataInfos($request, $id)
    {
        collect($request->name_columns)->each(function ($column, $key) use ($id, $request) {
            Laramin::model('DataInfo')->create([
                'data_types_id' => $id,
                'column' => str_slug($column),
                'type' => $request->type_columns[$key],
                'details' => $request->details[$key]["status"] ? json_encode($request->details[$key]["number"]) : null,
                'display' => array_key_exists($key, $request->array) ? !is_null($request->array[$key]) ? $request->array[$key] : false : false,
                'validation' => is_null($request->validation[$key]) ? null : json_encode($request->validation[$key])
            ]);
        });
    }

    public function putToMigrationFile($request)
    {

        if (Schema::hasTable($request->name)) {
            return;
        }

        $isTag = false;

        $content = collect();
        $type = collect(request()->type_columns);
        $column = collect($request->name_columns);

        $migration = new DatabaseType;

        for ($i = 0; $i < sizeof($column); $i++) {
            if ($type[$i] == "tags") {
                $isTag = true;
            }
            $content->push($migration->find($type[$i], $column[$i]));
            $contents = '';
            for ($i = 0; $i < sizeof($content); $i++) {
                $contents .= '$' . $content[$i];
            }
        }
        //Create Migration File
        Artisan::call('Laramin:migration', ['name' => 'create_' . $request->name . '_table', 'content' => $contents, '--table' => str_slug($request->name)]);
        
        //Create Model File
        Artisan::call('Laramin:model', ['name' => ucfirst($request->name), 'migration' => str_slug($request->name), 'tags' => $isTag]);
    }

    public function addPermissions($request)
    {
        $modules = ['create', 'update', 'delete', 'read'];

        //Add Permissions =>
        foreach ($modules as $module) {
            $permission = Permission::firstOrCreate([
                'name' => $module . '-' . Str::plural(strtolower(request()->name)),
                'display_name' => ucfirst($request->name) . ' ' . ucfirst($module),
                'description' => ucfirst($request->name) . ' ' . ucfirst($module),
            ]);
        }

        // $user = Laramin::model('User')->find($request->id)->role
    }
}