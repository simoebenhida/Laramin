<?php
if (!function_exists('slblog_menu_slugs')) {
    function slblog_menu_slugs()
    {
        return SLblog::getModelsSlug();
    }
}

if (!function_exists('slblog_basic_types')) {
    function slblog_basic_types()
    {
        return SLblog::getBasicTypes();
    }
}

if (!function_exists('slblog_menu_models')) {
    function slblog_menu_models()
    {
        return SLblog::getModelstoArray();
    }
}

if (!function_exists('slblog_get_active_menu')) {
    function slblog_get_active_menu()
    {
        $type = parse_url(request()->url());
        $type = collect($type);
        $path = $type->filter(function ($item, $index) {
            return $index == 'path';
        });

        if (! $path->isEmpty()) {
            $type = collect(explode('/', $type['path']));
            if ($type->contains(config('SLblog.prefix'))) {
                $type->shift();
                $type->shift();
                return $type;
            }
        }
    }
}
