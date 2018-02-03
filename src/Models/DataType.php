<?php

namespace Simoja\Laramin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DataType extends Model {

    protected $fillable = [
        'name', 'slug', 'model', 'menu'
    ];

    protected $with = ['infos'];

    public function infos()
    {
        return $this->hasMany('Simoja\Laramin\Models\DataInfo', 'data_types_id');
    }

    public function fillableColumns()
    {
        return $this->infos()
            ->get()
            ->filter(function ($item, $key)
            {
                if ($item->type == 'tags')
                {
                    return;
                }

                return $item;
            })->pluck('column');
    }

    public function toArray()
    {
        $permission = strtolower(Str::plural(lcfirst($this->name)));

        return array_merge(parent::toArray(), [
            'links' => [
                'browse'  => url(config('laramin.prefix') . "/{$this->slug}"),
                'addedit' => url(config('laramin.prefix') . "/{$this->slug}/create"),
            ],
            'infos' => $this->infos,
            'read'  => Auth::user()->hasPermission("read-{$permission}")
        ]);
    }
}
