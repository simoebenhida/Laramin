<?php

namespace Simoja\Laramin\Http\Controllers;
// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Simoja\Laramin\Facades\Laramin;

class LaraminModelController extends Controller
{
    protected $slug;
    protected $newRequest;
    protected $flashname = 'Laramin_Toast';

    public function getDataType()
    {
        return Laramin::model('DataType')->where('slug',$this->slug)->first();
    }
    public function getAllItems()
    {
        return Laramin::model($this->getDataType()->name)->orderBy('id', 'desc')->get();
    }
    public function getItemByID($id)
    {
        return Laramin::model($this->getDataType()->name)->find($id);
    }
    public function getColumns()
    {
        return $this->getDataType()->infos()->get();
    }
    public function getIndexColumns()
    {
        return $this->getDataType()->infos()->displayed()->get();
    }

    public function index(Request $request)
    {
        $this->slug = $this->getSlug($request);

         return view('laramin::models.browse')
                     ->withItems($this->getAllItems())
                     ->withColumns($this->getIndexColumns())
                     ->withType($this->getDataType());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->slug = $this->getSlug($request);
        // dd($this->getColumns());
        return view('laramin::models.add-edit')
                     ->withStatus('Add')
                     ->withColumns($this->getColumns())
                     ->withType($this->getDataType());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadImage($request)
    {
        $filename = auth()->id().'_'.date('Y_m_d_H_i_s');
        $extension = $request->getClientOriginalExtension();
        $filename = $filename.'.'.$extension;
        $path = $request->storeAs('public/'.$this->slug, $filename);
        return $filename;
    }
    public function getInfoOfType()
    {
        $type = collect();
        $this->getColumns()->each(function($item,$key) use($type) {
            $type->put($item->column,$item->type);
        });
        return $type;
    }
    public function exeptionsRequest($request,$type)
    {
        if($type->contains('image'))
        {
            $index = $type->search('image');
            $image = $this->uploadImage($request[$index]);
            $this->newRequest[$index] = $image;
        }
        if($type->contains('select_multiple'))
        {
            $index = $type->search('select_multiple');
            $this->newRequest[$index] = json_encode($request[$index]);
        }
    }

    public function relationAfterSaving($request,$model,$type)
    {
        if($type->contains('tags') && $request->tags)
        {
            //Check if Method Tags Exist
            $Id = collect();
            foreach (json_decode($request->tags) as $key => $value) {
                $Id->push($value->id);
            }
            // dd($Id);
            $model->tags()->sync($Id);
        }
    }

    public function checkForUnique($validation)
    {
        $check = collect(explode('|',$validation));
        $checking = $check->filter(function ($value,$key) {
            $value = collect(explode(':',$value));
            return $value->first() == 'unique';
        });
        return !! $checking->count();
    }
    public function validation(Request $request,$remove = [],$method = null)
    {
        $validation = collect();
        $remove = collect(['image']);
        $this->getColumns()->each(function ($item, $index) use ($validation,$remove,$method) {
                if(json_decode($item->validation) !== null)
                {
                    if(! $remove->contains($item->type))
                    {
                        if(! is_null($method) && $this->checkForUnique(json_decode($item->validation)))
                        {
                            $validation->put($item->column,json_decode($item->validation).','.$method);
                        }
                        else
                        {
                            $validation->put($item->column,json_decode($item->validation));
                        }
                    }
                }
        });
        $this->validate($request,$validation->toArray());
    }
    public function SessionMessage($message,$type)
    {
        $infos = collect();
        $infos->put('message',$message);
        $infos->put('type',$type);
        $infos->put('title',ucfirst($type));
        return $infos->toJson();
    }
    public function store(Request $request)
    {
        $this->slug = $this->getSlug($request);

        $this->newRequest = $request->all();

        $this->validation($request);

        $this->exeptionsRequest($request,$this->getInfoOfType());

        $model = Laramin::model($this->getDataType()->name)->create($this->newRequest);

        $this->relationAfterSaving($request,$model,$this->getInfoOfType());

        Session::flash($this->flashname,$this->SessionMessage("Your {$this->slug} Has Been Succesfully Added",'success'));

        return redirect()->route('laramin.'.$this->slug.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $this->slug = $this->getSlug($request);
        $item = $this->getItemByID($id);
        return view('laramin::models.add-edit')
                     ->withItem($item)
                     ->withStatus('Edit')
                     ->withColumns($this->getColumns())
                     ->withType($this->getDataType());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function checkUpdateValues($request,$item,$type)
    {
        $remove = collect();
        if($type->contains('image'))
        {
            $index = $type->search('image');
            if(is_null($request[$index]))
            {
                 $this->newRequest[$index] = $item[$index];
                 $remove->push('image');
            }
            else
            {
                $this->newRequest[$index] = $this->uploadImage($request[$index]);
            }
        }
        return $remove;
    }

    public function update(Request $request, $id)
    {
        $this->slug = $this->getSlug($request);

        $this->newRequest = $request->all();

        $itemById = Laramin::model($this->getDataType()->name)->find($id);

        $this->validation($request,$this->checkUpdateValues($request,$itemById,$this->getInfoOfType()),$itemById->id);


        $itemById->update($this->newRequest);

        $this->relationAfterSaving($request,$itemById,$this->getInfoOfType());

        Session::flash($this->flashname,$this->SessionMessage("Your {$this->slug} Has Been Succesfully Edited",'success'));


        return redirect()->route("laramin.{$this->slug}.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $this->slug = $this->getSlug($request);
        Laramin::model($this->getDataType()->name)->find($id)->delete();

        Session::flash($this->flashname,$this->SessionMessage("Your {$this->slug} Has Been Succesfully Destroyed",'success'));

        return redirect()->route("laramin.{$this->slug}.index");
    }
}
