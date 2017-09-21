<?php

namespace Simoja\Laramin\Models;

use Illuminate\Database\Eloquent\Model;

class DataInfo extends Model
{
    protected $fillable = [
        'column','data_types_id','validation','type','details','display'
    ];

    public function types()
    {
        return $this->belongsTo('Simoja\Laramin\Models\DataType');
    }

    public function scopeDisplayed($query)
    {
            $query->where('display', true);
    }

}
