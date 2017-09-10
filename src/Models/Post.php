<?php

namespace Simoja\Laramin\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'image', 'description','slug','status','featured','content'
    ];
}
