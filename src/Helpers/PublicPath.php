<?php
if (!function_exists('laramin_asset')) {
    function laramin_asset($path, $secure = null)
    {
        return asset(config('laramin.public_path').'/'.$path, $secure);
    }
}
