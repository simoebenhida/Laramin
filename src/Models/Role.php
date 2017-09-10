<?php

namespace Simoja\Laramin\Models;

use Laratrust\LaratrustRole;
use Simoja\Laramin\Facades\Laramin;

class Role extends LaratrustRole
{
    protected $fillable = [
        'name' , 'display_name','description'];

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'permission' => Laramin::getModelPermission($this)
         ]);
    }
}
