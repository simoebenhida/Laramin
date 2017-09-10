<?php

namespace Simoja\Laramin\Models;

use Laratrust\LaratrustPermission;

class Permission extends LaratrustPermission
{
    protected $fillable = ['name','display_name','description'];
}
