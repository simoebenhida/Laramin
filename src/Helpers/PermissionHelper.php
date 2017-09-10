<?php

// use App\User;
if (!function_exists('lramin_each_user_role')) {
    function laramin_each_user_role($user)
    {
        // dd($user->roles()->first()->name);
        if($user->roles()->count() > 0)
        {
        return $user->roles()->first()->name;
        }
        return '';
    }
}
if (!function_exists('laramin_get_roles')) {
    function laramin_get_roles()
    {
        return Laramin::model('Role')->all();
    }
}
if (!function_exists('laramin_get_users')) {
    function laramin_get_users()
    {
        return Laramin::model('User')->all()->toArray();
    }
}

if (!function_exists('laramin_each_user_permission')) {
    function laramin_each_user_permission($user)
    {
        return $user->permissions()->get();
    }
}
