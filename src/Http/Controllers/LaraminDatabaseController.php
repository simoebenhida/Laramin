<?php

namespace Simoja\Laramin\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Simoja\Laramin\Facades\Laramin;
use Simoja\Laramin\Traits\LaraminDatabase;

class LaraminDatabaseController extends Controller
{
    use LaraminDatabase;

    protected $basicType;
    protected $types = [];
    protected $columnNames = [];

    public function __construct()
    {
        $this->basicType = Laramin::getBasicTypes();
    }

    public function browse()
    {
        if (!$this->UserCan(auth()->user()->id, 'read-databases')) {
            abort(404);
        }
        return view('laramin::database.browse');
    }

    public function create()
    {
        if (!$this->UserCan(auth()->user()->id, 'create-databases')) {
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
        //Last Update : Refactoring 100 line to 20 line

        //Checking if user have permission
        if (!$this->UserCan($request->auth_id, 'create-databases')) {
            abort(404);
        }
        //Validate the database inputs
        $this->validate(
            $request,
            [
                'name' => 'required|alpha_dash',
                'slug' => 'required|alpha_dash|unique:data_types,slug',
            ]
        );

        $this->databaseStore($request);

        $this->putToMigrationFile($request);

        $this->addPermissions($request);
    }

    public function edit($id)
    {
        $type = Laramin::model('DataType')->find($id);

        return view('laramin::database.edit')->withType($type);
    }

    public function update(Request $request, $id)
    {
        if (!$this->UserCan(auth()->user()->id, 'update-databases')) {
            abort(404);
        }
        $type = Laramin::model('DataType')->find($id);
        $type->update([
            'menu' => $request->menu,
        ]);
        $type->infos->each(function ($item, $key) use ($request) {
            $item->update([
                'details' => array_key_exists('details_' . $item->id, request()->toArray()) ? $request['details_' . $item->id] : null,
                'validation' => array_key_exists('validation_' . $item->id, request()->toArray()) ? $request['validation_' . $item->id] : null,
                'display' => array_key_exists('display_' . $item->id, request()->toArray()) ? true : false
            ]);
        });
        Session::flash($this->flashname, $this->SessionMessage("Your {$type->name} Has Been Succesfully Edited", 'success'));

        return redirect()->route('laramin.database.browse');
    }

    protected function compileMigrationStub($name, $content)
    {
        return str_replace(
            ['DummyClass', 'DummyName', 'DummyTables'],
            ['Create' . ucfirst($name) . 'Table', strtolower($name), $content],
            file_get_contents(__DIR__ . "/stubs/migration.stub")
        );
    }

    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }

    public function destroy($auth, $id)
    {
        if (!$this->UserCan($auth, 'delete-databases')) {
            abort(404);
        }
        Laramin::model('DataType')->find($id)->delete();

        return response()->json(['success' => 1]);
    }
}
