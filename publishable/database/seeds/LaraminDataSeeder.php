<?php

use Illuminate\Database\Seeder;
// use faker\Factory as Faker;
use Simoja\Laramin\Models\DataType;
use Simoja\Laramin\Models\DataInfo;
use Simoja\Laramin\Models\Settings;

class LaraminDataSeeder extends Seeder
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
                        'required|max:150',
                        'text',
                        true,
                        null
                    ],
                    'slug' => [
                        'required|unique:posts,slug',
                        'text',
                        true,
                        null
                    ],
                    'content' => [
                        'required',
                        'rich_text_box',
                        false,
                        null
                    ],
                    'description' => [
                        'required|max:250',
                        'text_area',
                        false,
                        null
                    ],
                    'featured' => [
                        null,
                        'checkbox',
                        false,
                        null
                    ],
                    'tags' => [
                        null,
                        'tags',
                        false,
                        null
                    ],
                    'category' => [
                        'required',
                        'category',
                        false,
                        null
                    ],
                    'image' => [
                        'required|mimes:jpeg,bmp,png',
                        'image',
                        true,
                        null
                    ],
                    'status' => [
                        null,
                        'status',
                        true,
                        [
                            [
                                'value' => 'PUBLISHED',
                                'option' => 'PUBLISHED'
                            ],
                            [
                                'value' => 'PENDING',
                                'option' => 'PENDING'
                            ],
                            [
                                'value' => 'DRAFT',
                                'option' => 'DRAFT'
                            ]
                        ],
                    ]
                ],
               'Tag' => [
                    'name' => [
                        'required|max:156',
                        'text',
                        true,
                        null
                    ],
                    'slug' => [
                        'required|max:100|unique:tags,slug',
                        'string',
                        true,
                        null
                    ]
                ],
               'Category' => [
                    'name' => [
                        'required|max:156',
                        'text',
                        true,
                        null
                    ],
                    'slug' => [
                        'required|max:100|unique:categories,slug',
                        'string',
                        true,
                        null
                    ]
                ]
               ]);
      $settings = collect([
        'title' => [
            'Site Title',
            'text'
        ],
        'description' => [
            'Site Description',
            'text'
        ],
        'logo' => [
            'Site Logo',
            'image'
        ]
      ]);


        $this->command->info('Laramin Data Seeder');

        $this->command->info('Seed Settings');
        $settings->each(function($value,$index) {
            $this->command->info('Creating Settings for '.$index);
            Settings::create([
                    'key' => $index,
                    'display_name' => $value[0],
                    'type' => $value[1],
            ]);
        });


        $models->each(function ($model, $index) use ($columns) {
            $this->command->info('Creating Data Type to '.$index);

            $res = DataType::create([
                        'name' => $index,
                        'menu' => true,
                        'model' =>  $index,
                        'slug' => strtolower($index),
                    ]);
            $id = $res->id;
            $columns->filter(function ($item, $key) use ($index, $id) {
                return $key == $index;
            })->Flatmap(function ($item, $key) use ($id) {
                return $item;
            })->each(function ($item, $key) use ($id) {
                $this->command->info('Creating Data Info '.$key.' for '.DataType::find($id)->name);

                DataInfo::create([
                        'data_types_id' => $id,
                        'column' => $key,
                        'type' => $item[1],
                        'validation' => $item[0] == null ? NULL : json_encode($item[0]),
                        'details' => $item[3] == null ? NULL : json_encode($item[3]),
                        'display' => $item[2]
                    ]);
            });
        });
    }
}
