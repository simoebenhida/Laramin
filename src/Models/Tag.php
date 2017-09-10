<?php

namespace Simoja\Laramin\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
       'name','slug'
    ];
}
