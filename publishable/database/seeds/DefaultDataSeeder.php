<?php

use Illuminate\Database\Seeder;
// use faker\Factory as Faker;
use App\DataType;
use App\DataInfo;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         //Get The Models To put In Database
        $models = collect([
                    'Post' => Post::class,
                    'Tag' => Tag::class,
                    'Category' => Category::class
                     ]);

        //Each Model Got His Attribues
        $columns = collect([
               'Post' => [
                    'title' => [
                        'required|max:150'
                    ],
                    'slug' => [
                        'required|unique:posts'
                    ],
                    'content' => [
                        'required'
                    ],
                    'description' => [
                        'required|max:250'
                    ],
                    'featured' => [
                        'required|max:154'
                    ],
                    'image' => [
                        'required|mimes:jpeg,bmp,png'
                    ],
                    'status' => [
                        'required'
                    ]
                ],
               'Tag' => [
                    'name' => [
                        'required|max:156'
                    ],
                    'slug' => [
                        'required|max:100|unique:tags'
                    ]
                ],
               'Category' => [
                    'name' => [
                        'required|max:156'
                    ],
                    'slug' => [
                        'required|max:100|unique:categories'
                    ]
                ]
               ]);

            $this->command->info('SLblog Data Seeder');

             $models->each(function($model,$index) use($columns) {

                    $this->command->info('Creating Data Type to '.$index);

                    $res = DataType::create([
                        'name' => $index,
                        'slug' => strtolower($index),
                    ]);
                     $id = $res->id;
                $columns->filter(function($item,$key) use($index,$id) {

                    return $key == $index;

                })->Flatmap(function($item,$key) use($id) {

                    return $item;

                })->each(function($item,$key) use($id) {

                     $this->command->info('Creating Data Info '.$key.' for '.DataType::find($id)->name);

                    DataInfo::create([
                        'data_types_id' => $id,
                        'column' => $key,
                        'validation' => json_encode($item)
                    ]);
                });
            });
    }
}
