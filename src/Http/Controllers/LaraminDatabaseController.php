<?php
namespace Simoja\Laramin\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
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
        if(! $this->UserCan(auth()->user()->id,'read-databases'))
            {
                abort(404);
            }
        return view('laramin::database.browse');
    }

    public function create()
    {
        if(! $this->UserCan(auth()->user()->id,'create-databases'))
            {
                abort(404);
            }
        return view('laramin::database.add');
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
            if(! $this->UserCan($request->auth_id,'create-databases'))
            {
                abort(404);
            }
        $this->validate($request,
            [
            'nameType' => 'required|alpha_dash',
            'slugType' => 'required|alpha_dash|unique:data_types,slug',
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
            $value = str_replace(' ', '_', strtolower($value));
            Laramin::model('DataInfo')->create([
                    'data_types_id' => $id,
                    'column' => $value,
                    'type' => request()->type_columns[$key],
                    'details' => request()->details[$key]["status"] ? json_encode(request()->details[$key]["number"]) : NULL,
                    'display' => array_key_exists($key,request()->array) ? request()->array[$key] : false,
                    'validation' => is_null(request()->validation[$key]) ? NULL : json_encode(request()->validation[$key])
                ]);
        });

        $this->types = collect(request()->type_columns);
        // //Add To Migration file
        if (! Schema::hasTable(request()->nameType)) {
            $content = collect();
            $oldType = $this->types;
            $oldColumn = $this->columnNames;
             for ($i=0;$i<sizeof($oldColumn);$i++)
                {
                    $type = $oldType[$i];
                    if ($type == 'date') {
                        $content->push("table->date('{$oldColumn[$i]}');\n");
                    }
                    if($type == 'status')
                    {
                    $content->push("table->enum('{$oldColumn[$i]}', ['PUBLISHED', 'DRAFT', 'PENDING'])->default('DRAFT');\n");
                    }
                    if (($type == 'string') || ($type == 'file') || ($type== 'image') || ($type == 'password') || ($type == 'select_dropdown') || ($type == 'radio_btn'))
                    {
                        $content->push("table->string('{$oldColumn[$i]}');\n");
                    }
                    if (($type == 'checkbox') || ($type == 'radio_btn')) {
                        $content->push("table->boolean('{$oldColumn[$i]}');\n");
                    }
                    if ($type == 'number') {
                        $content->push("table->float('{$oldColumn[$i]}');\n");
                    }
                    if (($type == 'json') || ($type == 'select_multiple')) {
                        $content->push("table->json('{$oldColumn[$i]}');\n");
                    }
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
        Artisan::call('Laramin:migration', ['name' => 'create_'.request()->nameType.'_table', 'content' => $contentValue ,'--table' => request()->nameType]);
        $modules =['create','update','delete','read'];

        //Add Permissions =>
        foreach ($modules as $module) {
            $permission = Permission::firstOrCreate([
                        'name' => $module.'-'.Str::plural(strtolower(request()->nameType)),
                        'display_name' => ucfirst(request()->nameType) . ' ' . ucfirst($module),
                        'description' => ucfirst(request()->nameType) . ' ' . ucfirst($module),
                    ]);
        }
        // $nameType = ucfirst(request()->nameType);
        // Session::flash($this->flashname,$this->SessionMessage("Your {$nameType} Has Been Succesfully Added",'success'));

        //Create Model File
        Artisan::call('Laramin:model', ['name' => ucfirst(request()->nameType), 'migration' => request()->nameType]);
        }
    }

    public function edit($id)
    {
        $type = Laramin::model('DataType')->find($id);

        return view('laramin::database.edit')->withType($type);
    }

    public function update(Request $request,$id)
    {
        if(! $this->UserCan(auth()->user()->id,'update-databases'))
            {
                abort(404);
            }
        $type = Laramin::model('DataType')->find($id);
        $type->update([
            'menu' => $request->menu,
            ]);
        $type->infos->each(function($item,$key) use($request) {
            $item->update([
                'details' => array_key_exists('details_'.$item->id,request()->toArray()) ? $request['details_'.$item->id] : null,
                'validation' => array_key_exists('validation_'.$item->id,request()->toArray()) ? $request['validation_'.$item->id] : null,
                'display' => array_key_exists('display_'.$item->id,request()->toArray()) ? true : false
                ]);
        });
        Session::flash($this->flashname,$this->SessionMessage("Your {$type->name} Has Been Succesfully Edited",'success'));

        return redirect()->route('laramin.database.browse');
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
    public function destroy($id)
    {
        if(! $this->UserCan(auth()->user()->id,'delete-databases'))
            {
                abort(404);
            }
        Laramin::model('DataType')->find($id)->delete();
        return redirect()->route('laramin.database.browse');
    }
}
