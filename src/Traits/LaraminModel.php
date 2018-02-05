<?php
namespace Simoja\Laramin\Traits;

use Illuminate\Http\Request;
use Simoja\Laramin\Facades\Laramin;

trait LaraminModel
{
    //getAllItems
    public function items()
    {
        return Laramin::model($this->type->name)->latest()->get();
    }

    //getItemById
    public function item($id)
    {
        return Laramin::model($this->type->name)->find($id);
    }

    //getColumns
    public function columns()
    {
        return $this->type->infos()->get();
    }

    //getIndexColumns
    public function displayedColumns()
    {
        return $this->type->infos()->displayed()->get();
    }

    //uploadImage
    public function upload($request)
    {
        $filename = auth()->id() . '_' . date('Y_m_d_H_i_s');
        $extension = $request->getClientOriginalExtension();
        $filename = $filename . '.' . $extension;
        $path = $request->storeAs('public/' . $this->slug, $filename);
        return $filename;
    }

    public function typesInfos()
    {
        $type = collect();
        $this->columns()->each(function ($item, $key) use ($type) {
            $type->put($item->column, $item->type);
        });
        return $type;
    }

    //exeptionsRequest
    public function HandleRequest($request)
    {
        if ($this->typesInfos()->contains('image')) {
            $name = $this->type->search('image');
            if ($request[$name]) {
                $image = $this->upload($request[$name]);
                $request[$name] = $image;
            }
        }

        if ($this->typesInfos()->contains('select_multiple')) {
            $name = $this->type->search('select_multiple');
            if ($request[$name]) {
                $request[$name] = json_encode($request[$name]);
            }
        }
        return $request;
    }

    public function relationAfterSaving($request, $model, $type, $store)
    {
        if ($type->contains('tags')) {
            $index = $type->search('tags');
            $id = collect();

            foreach (json_decode($request[$index]) as $key => $value) {
                $id->put($value->id, ['parent_type' => get_class($model)]);
            }
            $model->tags()->sync($id->toArray());
        }
    }

    public function unique($validation)
    {
        return !! collect(explode('|', $validation))->filter(function ($value, $key) {
            $value = collect(explode(':', $value));
            return $value->first() == 'unique';
        })
        ->count();
    }

    public function validationValue($item, $id = null)
    {
        if ($id && $this->unique($item->validation)) {
            return json_decode($item->validation).','.$item->column.','.$id;
        }
        return json_decode($item->validation);
    }

    public function validation(Request $request, $id = null)
    {
        $validation = collect();
        $remove = collect(['image']);

        $this->columns()->each(function ($item, $index) use ($validation, $remove, $id) {
            if (json_decode($item->validation) && !$remove->contains($item->type)) {
                $validation->put($item->column, $this->validationValue($item, $id));
            }
        });

        $this->validate($request, $validation->toArray());
    }
}
