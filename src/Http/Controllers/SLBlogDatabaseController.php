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
    protected $basicType;
    protected $types = [];
    protected $columnNames = [];
    public function __construct()
    {
        $this->basicType = SLblog::getBasicTypes();
    }

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
    public function store(Request $request)
    {
        $this->validate($request,
            [
            'nameType' => 'required',
            'slugType' => 'required',
            'defaultFirstNameColumn' => 'required',
            ],
            [
             'defaultFirstNameColumn.required' => 'The column name field is required'
            ]
            );
        $this->columnNames = collect(request()->name_columns);
        //Store Info on database
        $modelType = SLblog::model('DataType')->create([
                'name' => request()->nameType,
                'slug' => request()->slugType
            ]);
        $id = $modelType->id;
        $this->columnNames->each(function ($value, $key) use ($id) {
            SLblog::model('DataInfo')->create([
                    'data_types_id' => $id,
                    'column' => $value,
                    'type' => request()->type_columns[$key],
                    'validation' => json_encode(request()->validation[$key])
                ]);
        });

        $this->types = collect(request()->type_columns);

        //Add To Database
        if (! Schema::hasTable(request()->nameType)) {
            Schema::create(request()->nameType, function (Blueprint $table) {
                // $this->findType('text');
                $table->increments('id');
                while (sizeof($this->types) > 0) {
                    $callItOnce = $this->types->shift();
                    if ($callItOnce == 'date') {
                        $table->date($this->columnNames->shift());
                    }
                    if (($callItOnce == 'string') || ($callItOnce == 'file') || ($callItOnce== 'image') || ($callItOnce == 'password'))
                    {
                        $table->string($this->columnNames->shift());
                    }
                    if (($callItOnce == 'checkbox') || ($callItOnce == 'radio_btn')) {
                        $table->boolean($this->columnNames->shift());
                    }
                    if ($callItOnce == 'number') {
                        $table->float($this->columnNames->shift());
                    }
                    if ($callItOnce == 'json') {
                        $table->json($this->columnNames->shift());
                    }
                    if ($callItOnce == 'text') {
                        $table->text($this->columnNames->shift());
                    }
                    if (($callItOnce == 'rich_text_box') || ($callItOnce == 'text_area')) {
                        $table->longText($this->columnNames->shift());
                    }
                     if ($callItOnce == 'timestamp') {
                        $table->timestamp($this->columnNames->shift());
                     }
                }
            });
        }
        //Create Model File
        Artisan::call('SLblog:model', ['name' => ucfirst(request()->model), 'migration' => request()->nameType]);
    }
}
