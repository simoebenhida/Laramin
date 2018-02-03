<?php

namespace Simoja\Laramin\Helpers;

class DatabaseType
{

    // protected $type;
    // protected $column;

    // public function __construct($type, $column)
    // {
    //     $this->type = $type;
    //     $this->column = $column;
    // }

    public function find($type, $column)
    {
        return $this->$type($column);
    }

    public function date($column)
    {
        return "table->date('{$column}');\n";
    }

    public function status($column)
    {
        return "table->enum('{$column}', ['PUBLISHED', 'DRAFT', 'PENDING'])->default('DRAFT');\n";
    }

    public function string($column)
    {
        return "table->string('{$column}');\n";
    }

    public function file($column)
    {
        return "table->string('{$column}');\n";
    }

    public function image($column)
    {
        return "table->string('{$column}');\n";
    }

    public function password($column)
    {
        return "table->string('{$column}');\n";
    }

    public function select_dropdown($column)
    {
        return "table->string('{$column}');\n";
    }

    public function radio_btn($column)
    {
        return "table->string('{$column}');\n";
    }

    public function checkbox($column)
    {
        return "table->boolean('{$column}');\n";
    }
    public function number($column)
    {
        return "table->float('{$column}');\n";
    }
    public function json($column)
    {
        return "table->json('{$column}');\n";
    }

    public function select_multiple($column)
    {
        return "table->json('{$column}');\n";
    }

    public function text($column)
    {
        return "table->text('{$column}');\n";
    }

    public function rich_text_box($column)
    {
        return "table->longText('{$column}');\n";
    }

    public function text_area($column)
    {
        return "table->longText('{$column}');\n";
    }

    public function timestamp($column)
    {
        return "table->timestamp('{$column}');\n";
    }

}