<?php
if (!function_exists('slblog_asset')) {
    function slblog_asset($path, $secure = null)
    {
        return asset(config('SLblog.public_path').'/'.$path, $secure);
    }
}
