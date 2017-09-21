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
