<?php
if (!function_exists('laramin_select_dropdown')) {
    function laramin_select_dropdown($details)
    {
        return json_decode($details);
    }
}

if (!function_exists('laramin_select_multiple_value')) {
    function laramin_select_multiple_value($value = '')
    {
        $collecting = collect();
        if($value !== '')
        {
        $values = json_decode($value);
        foreach ($values as $val) {
            $collecting->push($val);
        }
        }
        return $collecting;
    }
}
if (!function_exists('laramin_get_tags')) {
    function laramin_get_tags($id = null,$slug)
    {
        $values = collect();

        if($id !== null)
        {
            $tags = Laramin::model($slug)->find($id)->TagsModel($slug);
            $tags->each(function($value,$index) use ($values) {
                $values->push([
                    'id' => $value->id,
                    'name' => $value->name
                ]);
            });
        }
        return $values->toJson();
    }
 }
