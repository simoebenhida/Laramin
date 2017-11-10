<?php

namespace Simoja\Laramin\Models;

use Illuminate\Database\Eloquent\Model;

class TagsRelation extends Model
{
    protected $fillable = [
        'parent','tag_id','other_id'
    ];
}
