<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// if (!function_exists('laramin_getSlug')) {
//     function laramin_getSlug()
//     {
//          return explode('.', $request->route()->getName())[1];
//     }
// }
if (!function_exists('laramin_menu_slugs')) {
    function laramin_menu_slugs()
    {
        return Laramin::getModelsSlug();
    }
}

if (!function_exists('laramin_basic_types')) {
    function laramin_basic_types()
    {
        return Laramin::getBasicTypes();
    }
}

if (!function_exists('laramin_menu_models')) {
    function laramin_menu_models()
    {
        return Laramin::getModelstoArray();
    }
}
if (!function_exists('laramin_read_permission_menu')) {
    function laramin_read_permission_menu()
    {
        $tools = ['users','roles','databases','settings'];
        $permission = collect();
        foreach($tools as $tool) {
            $permission->put($tool,Auth::user()->hasPermission("read-{$tool}"));
        }
       return $permission;
    }
}
if (!function_exists('laramin_get_active_menu')) {
    function laramin_get_active_menu()
    {
        $type = parse_url(request()->url());
        $type = collect($type);
        $path = $type->filter(function ($item, $index) {
            return $index == 'path';
        });

        if (! $path->isEmpty()) {
            $type = collect(explode('/', $type['path']));
            if ($type->contains(config('laramin.prefix'))) {
                $type->shift();
                $type->shift();
                $laramin = Laramin::model('DataType')->where('slug',$type->first())->first();
                if($laramin)
                {
                     return collect([strtolower($laramin->name)]);
                }
                return $type;
            }
        }
    }
}
if (!function_exists('laramin_get_single_permission')) {
    function laramin_get_single_permission($user)
    {
        $active = laramin_get_active_menu();
        $active = Str::plural($active->first());
        $permission = collect();
        $permission->put("create",$user->hasPermission("create-{$active}"));
        $permission->put("read",$user->hasPermission("read-{$active}"));
        $permission->put("update",$user->hasPermission("update-{$active}"));
        $permission->put("delete",$user->hasPermission("delete-{$active}"));
        return $permission;
    }
 }

