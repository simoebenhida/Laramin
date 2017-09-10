<?php
namespace Simoja\Laramin\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Simoja\Laramin\Facades\Laramin;
use Simoja\Laramin\Models\Permission;

class LaraminDatabaseController extends Controller
{
    protected $basicType;
    protected $types = [];
    protected $columnNames = [];
    public function __construct()
    {
        $this->basicType = Laramin::getBasicTypes();
    }

    public function browse()
    {
        return view('laramin::database.browse');
    }

    public function create()
    {
        return view('laramin::database.add-edit');
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
        $modelType = Laramin::model('DataType')->create([
                'name' => ucfirst(request()->nameType),
                'model' => ucfirst(request()->nameType),
                'menu' => request()->menu,
                'slug' => request()->slugType
            ]);
        $id = $modelType->id;
        $this->columnNames->each(function ($value, $key) use ($id) {
            Laramin::model('DataInfo')->create([
                    'data_types_id' => $id,
                    'column' => $value,
                    'type' => request()->type_columns[$key],
                    'details' => request()->details[$key]["status"] ? json_encode(request()->details[$key]["number"]) : NULL,
                    'display' => array_key_exists($key,request()->array) ? request()->array[$key] : false,
                    'validation' => json_encode(request()->validation[$key])
                ]);
        });

        $this->types = collect(request()->type_columns);

        // //Add To Database
        if (! Schema::hasTable(request()->nameType)) {
            $content = collect();
            $oldType = $this->types;
            $oldColumn = $this->columnNames;
             for ($i=0;$i<sizeof($oldType);$i++)
                {
                    $type = $oldType[$i];
                    if ($type == 'date') {
                        $content->push("table->date('{$oldColumn[$i]}');\n");
                    }
                    if (($type == 'string') || ($type == 'file') || ($type== 'image') || ($type == 'password') || ($type == 'select_dropdown') || ($type == 'select_multiple') || ($type == 'radio_btn'))
                    {
                        $content->push("table->string('{$oldColumn[$i]}');\n");
                    }
                    if (($type == 'checkbox') || ($type == 'radio_btn')) {
                        $content->push("table->boolean('{$oldColumn[$i]}');\n");
                    }
                    if ($type == 'number') {
                        $content->push("table->float('{$oldColumn[$i]}');\n");
                    }
                    // if ($type == 'json') {
                    //     $content->push("table->json('{$oldColumn[$i]}');\n");
                    // }
                    if ($type == 'text') {
                        $content->push("table->text('{$oldColumn[$i]}');\n");
                    }
                    if (($type == 'rich_text_box') || ($type == 'text_area')) {
                        $content->push("table->longText('{$oldColumn[$i]}');\n");
                    }
                     if ($type == 'timestamp') {
                        $content->push("table->timestamp('{$oldColumn[$i]}');\n");
                     }
                }
                $contentValue = '';
                for ($i=0;$i<sizeof($content);$i++)
                {
                    $contentValue .= '$'.$content[$i];
                }

            // Schema::create(request()->nameType, function (Blueprint $table) {
            //     // $this->findType('text');
            //     $table->increments('id');
            //     while (sizeof($this->types) > 0) {
            //         $type = $this->types->shift();
            //         if ($type == 'date') {
            //             $table->date($this->columnNames->shift());
            //         }
            //        if(($type == 'string') || ($type == 'file') || ($type== 'image') || ($type == 'password') || ($type == 'select_dropdown') || ($type == 'select_multiple') || ($type == 'radio_btn'))
            //        {
            //             $table->string($this->columnNames->shift());
            //        }
            //         if (($type == 'checkbox') || ($type == 'radio_btn')) {
            //             $table->boolean($this->columnNames->shift());
            //         }
            //         if ($type == 'number') {
            //             $table->float($this->columnNames->shift());
            //         }
            //         if ($type == 'json') {
            //             $table->json($this->columnNames->shift());
            //         }
            //         if ($type == 'text') {
            //             $table->text($this->columnNames->shift());
            //         }
            //         if (($type == 'rich_text_box') || ($type == 'text_area')) {
            //             $table->longText($this->columnNames->shift());
            //         }
            //          if ($type == 'timestamp') {
            //             $table->timestamp($this->columnNames->shift());
            //          }
            //     }
            //         $table->timestamps();
            // });

            // $filename = $this->getDatePrefix().'_create_'.Str::studly(strtolower(request()->nameType));
            //  file_put_contents(
            //         database_path("migrations/{$filename}.php"),
            //         $this->compileMigrationStub(request()->nameType,$contentValue)
            //     );
        }

        $modules =['create','update','delete','read'];
        //Add Permissions =>
        foreach ($modules as $module) {
            $permission = Permission::firstOrCreate([
                        'name' => $module.'-'.Str::plural(strtolower(request()->nameType)),
                        'display_name' => ucfirst(request()->nameType) . ' ' . ucfirst($module),
                        'description' => ucfirst(request()->nameType) . ' ' . ucfirst($module),
                    ]);
        //Assign Permission To Current User
        }
        //Create Model File
        // Artisan::call('migrate');
        Artisan::call('Laramin:model', ['name' => ucfirst(request()->nameType), 'migration' => request()->nameType]);
        Artisan::call('Laramin:migration', ['name' => 'create_'.request()->nameType.'_table', 'content' => $contentValue ,'--table' => request()->nameType]);


    }

    protected function compileMigrationStub($name,$content)
    {
        return str_replace(
             ['DummyClass','DummyName','DummyTables'],
             ['Create'.ucfirst($name).'Table',strtolower($name),$content],
             file_get_contents(__DIR__."/stubs/migration.stub")
        );
    }
     protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }
}
