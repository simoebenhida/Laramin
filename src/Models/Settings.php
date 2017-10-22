<?php

namespace Simoja\Laramin\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'key','display_name','value','type'
    ];
}
