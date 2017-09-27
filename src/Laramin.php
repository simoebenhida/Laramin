<?php
namespace Simoja\Laramin;


use Simoja\Laramin\Models\DataInfo;
use Simoja\Laramin\Models\DataType;
use Simoja\Laramin\Models\Permission;
use Simoja\Laramin\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**

  TODO:
  - Add New Type By The User Using http://laravel-recipes.com/recipes/132/appending-to-a-file
 */


class Laramin
{
    protected $BasicModels = [
          'DataType' => DataType::class,  //Must be The First Element
          'DataInfo' => DataInfo::class, //The Same
          // 'User'  => User::class,
          'Permission' => Permission::class,
          'Role' => Role::class,
          'Database' => null
      ];

    protected $BasicTypes = [
        'string' => 'String',
        'checkbox' => 'CheckBox',
        'date' => 'Date',
        'file' => 'File',
        'image' => 'Image',
        'number' => 'Number',
        'password' => 'Password',
        'radio_btn' => 'Radio Button',
        'rich_text_box' => 'Richest Text Box',
        'select_dropdown' => 'Select Dropdow',
        'select_multiple' => 'Select Multiple',
        'text' => 'Text',
        'status' => 'Status',
        'text_area' => 'Text Area',
        'timestamp' => 'TimesTamp',
        ];

    protected $ExtraModels = [];

    protected $AllModels = [];

    protected $ExtraModelSlug = [];

    protected $DataType;

    protected $getEnabledModels = [];

    public function __construct()
    {
        $this->ExtraModels = collect([
             'User' => \App\User::class,
             // 'Post' => Post::class,
             // 'Category' => Category::class,
             // 'Tag' => Tag::class
             ]);
        $this->BasicModels = collect($this->BasicModels);
        $this->setDataType();
        $this->setExtraModels();
        $this->getbackModels();
        $this->getEnabledModel();
    }

    public function routes()
    {
        require __DIR__.'/routes.php';
    }
    public function ApiRoutes()
    {
        require __DIR__.'/api_routes.php';
    }
    public function setDataType()
    {
        $this->DataType = collect();
        if (Schema::hasTable('data_types')) {
            $this->DataType = DataType::all();
        }
    }
    public function setExtraModels()
    {
        $this->DataType->each(function ($item, $key) {
            $this->ExtraModels->put($item->name, 'App\\'.$item->name);
        });
    }
    public function getExtraModels()
    {
        return $this->ExtraModels->all();
    }

    public function getModelstoArray()
    {
        return DataType::where('menu',true)->get()->toArray();
    }

    public function getModelsSlug()
    {
        $this->ExtraModelSlug = $this->DataType->pluck('slug');
        return $this->ExtraModelSlug;
    }

    public function getEnabledModel()
    {
        //Always Delete The 2 First Elements
        $basicModel = $this->BasicModels;
        $basicModel->shift();
        $basicModel->shift();
        $this->getEnabledModels = $basicModel->merge($this->ExtraModels);
    }
    public function getAllModels()
    {
        return $this->getEnabledModels;
    }
    public function getbackModels()
    {
        $this->AllModels = $this->BasicModels->merge($this->ExtraModels);
        return $this->AllModels;
    }
    public function getBasicTypes()
    {
        return $this->BasicTypes;
    }
    public function parseToCollect($array)
    {
        return collect($array);
    }
    public function getModelPermission($user)
    {
            //make an array each Index User with boolean permission (create,edit,delete,read)
            $modelPermission = collect([]);
             Laramin::getAllModels()->each(function($item,$key) use($user,$modelPermission) {
                    $modelPermission->put($key,[
                           'read' => $user->hasPermission('read-'. Str::plural(strtolower($key))),
                           'create' => $user->hasPermission('create-'. Str::plural(strtolower($key))),
                           'update' => $user->hasPermission('update-'. Str::plural(strtolower($key))),
                          'delete'  => $user->hasPermission('delete-'. Str::plural(strtolower($key)))
                   ]);
           });
             return $modelPermission;
    }
    public function model($name)
    {
        return app($this->AllModels[studly_case($name)]);
    }
}
