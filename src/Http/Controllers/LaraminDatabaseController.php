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
use Illuminate\Support\Facades\Artisan;

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
        if (!$this->can('read-databases', auth()->id())) {
            abort(404);
        }
        return view('laramin::database.browse');
    }

    public function create()
    {
        if (!$this->can('create-databases', auth()->id())) {
            abort(404);
        }
        return view('laramin::database.add');
    }

    public function store(Request $request)
    {
        if (!$this->can('create-databases', $request->auth_id)) {
            abort(404);
        }

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
        if (!$this->can('update-databases', $request->auth_id)) {
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

    public function destroy($auth, $id)
    {
        if (!$this->can('delete-databases', $auth)) {
            abort(404);
        }

        $type = Laramin::model('DataType')->find($id);

        Artisan::call('Laramin:delete', ['name' => $type->name]);

        $type->delete();

        return response()->json(['success' => 1]);
    }
}
