<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
       'name','slug'
    ];
    public function details($id = null)
    {
        if ($id) {
            return [
                'id' => $this->id,
                'name' => $this->name
            ];
        }
        $tags = $this->all();
        $values = collect();
        $tags->each(function($value,$index) use ($values) {
            $values->push([
                'id' => $value->id,
                'name' => $value->name
            ]);
        });
        return $values->toJson();
    }

    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }
}
