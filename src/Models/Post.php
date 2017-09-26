<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'image', 'description','slug','status','featured','content','category'
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function categories()
    {
        return $this->hasOne('App\Category');
    }
}
