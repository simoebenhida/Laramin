<?php
namespace Simoja\SLblog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Simoja\SLblog\Facades\SLblog;

class SLBlogDatabaseController extends Controller
{
    protected $types = [];

    public function browse()
    {
        return view('slblog::database.browse');
    }

    public function create()
    {
        return view('slblog::database.add-edit');
    }
    public function findType($type = [])
    {
        $type = collect($type);
        $something = $this->types->filter(function ($value, $key) use ($type) {
            return $type->contains($key);
        });
        return stripslashes($something->first());
    }
    public function store()
    {
        //Store Info on database
        // dd(collect(request()->columns));

        $modelType = SLblog::model('DataType')->create([
                'name' => request()->nameType,
                'slug' => request()->slugType
            ]);
        $id = $modelType->id;
        collect(request()->name_columns)->each(function ($value, $key) use ($id) {
            SLblog::model('DataInfo')->create([
                    'data_types_id' => $id,
                    'column' => $value,
                    'validation' => json_encode([request()->validation[$key]])
                ]);
        });
        $this->types = collect(request()->type_columns);
        // collect(request()->columns)->each(function ($value, $key) {
        //     dd($key[0]);
        // });
        //Add To Database
        // dd($this->findType('text'));
        //        <option value="checkbox">Checkbox</option>
        //  <option value="date">Date</option>
        //  <option value="file">File</option>
        //  <option value="image">Image</option>
        //  <option value="multiple_images">Multiple Images</option>
        // <option value="number" selected="">Number </option>
        //  <option value="password">Password</option>
        //  <option value="radio_btn">Radio Button</option>
        //  <option value="rich_text_box">Rich Text Box</option>
        //  <option value="select_dropdown"> Select Dropdown </option>
        //  <option value="select_multiple">Select Multiple</option>
        //  <option value="text">Text</option>
        //  <option value="text_area">Text Area</option>
        //  <option value="timestamp">Timestamp </option>
        //  <option value="hidden">Hidden</option>
        //  <option value="code_editor">Code Editor </option>
        if (! Schema::hasTable(request()->nameType)) {
            Schema::create(request()->nameType, function (Blueprint $table) {
                // $this->findType('text');
                $table->increments('id');
                if ($this->types->contains('text')) {
                    $table->string("test");
                }
            });
        }
        //Create Model File
        Artisan::call('SLblog:model', ['name' => request()->model, 'migration' => request()->nameType]);
    }
}
