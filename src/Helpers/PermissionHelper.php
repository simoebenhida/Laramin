<?php

use App\User;
if (!function_exists('slblog_each_user_role')) {
    function slblog_each_user_role($user)
    {
        return $user->roles()->first()->name;
    }
}
if (!function_exists('slblog_get_roles')) {
    function slblog_get_roles()
    {
        return SLblog::model('Role')->all();
    }
}
if (!function_exists('slblog_get_users')) {
    function slblog_get_users()
    {
        return SLblog::model('User')->all()->toArray();
    }
}

if (!function_exists('slblog_each_user_permission')) {
    function slblog_each_user_permission(User $user)
    {
        return $user->permissions()->get();
    }
}
