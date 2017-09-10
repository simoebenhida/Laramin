<?php
if (!function_exists('laramin_asset')) {
    function laramin_asset($path, $secure = null)
    {
        return asset(config('Laramin.public_path').'/'.$path, $secure);
    }
}
