<?php
namespace Simoja\SLblog;
use App\User;
use App\Permission;
use App\Role;
use App\Post;
use App\Tag;
use App\Category;
use App\DataType;
use App\DataInfo;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Collection;
/**

  TODO:
  - Add New Type By The User Using http://laravel-recipes.com/recipes/132/appending-to-a-file
 */


class SLblog
{
	 protected $BasicModels = [
          'User'  => User::class,
          'Permission' => Permission::class,
          'Role' => Role::class
      ];

      protected $ExtraModels;

      protected $AllModels;


      public function __construct()
      {
          $this->ExtraModels = collect([]);
          $this->BasicModels = collect($this->BasicModels);

          if(Schema::hasTable('data_types')){
          DataType::all()->each(function ($item,$key) {
                $this->ExtraModels->put($item->name,'App\\'.$item->name);
          });
          }
          $this->AllModels = $this->BasicModels->merge($this->ExtraModels);
      }

      public function routes()
      {
          require __DIR__.'/routes.php';
      }

      public function getExtraModels()
      {
          return $this->ExtraModels->all();
      }

      public function getModelstoArray()
      {
        return DataType::all()->toArray();
      }

      public function getModelsSlug()
      {
        return DataType::all()->pluck('slug');
      }

      public function getAllModels()
      {
        return $this->AllModels;
      }

    	public function model($name)
    	{
    		return app($this->AllModels[studly_case($name)]);
    	}
}