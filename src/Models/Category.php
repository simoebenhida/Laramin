<?php

namespace Simoja\Laramin\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
       'name','slug'
    ];
}
