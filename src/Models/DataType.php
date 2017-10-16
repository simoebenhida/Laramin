<?php

namespace Simoja\Laramin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DataType extends Model
{
    protected $fillable = [
        'name','slug','model','menu'
    ];

    public function infos()
    {
        return $this->hasMany('Simoja\Laramin\Models\DataInfo', 'data_types_id');
    }

    public function toArray()
    {
        $permission = Str::plural(lcfirst($this->name));
        return array_merge(parent::toArray(), [
            'links' => [
                'browse' => url(config('laramin.prefix')."/{$this->slug}"),
                'addedit' => url(config('laramin.prefix')."/{$this->slug}/create"),
                ],
            'read' => Auth::user()->hasPermission("read-{$permission}")
         ]);
    }
}
