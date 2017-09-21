<?php

namespace Simoja\Laramin\Http\Controllers;
// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Simoja\Laramin\Facades\Laramin;

class LaraminModelController extends Controller
{
    protected $slug;

    public function getDataType()
    {
        return Laramin::model('DataType')->where('slug',$this->slug)->first();
    }
    public function getAllItems()
    {
        return Laramin::model($this->getDataType()->name)->get();
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
    public function exeptionsRequest($request)
    {
        $type = collect();
        $this->getColumns()->each(function($item,$key) use($type) {
            $type->put($item->column,$item->type);
        });

        $newRequest = $request->all();
        if($type->contains('image'))
        {
            $index = $type->search('image');
            $image = $this->uploadImage($request[$index]);
            $newRequest[$index] = $image;
        }
        if($type->contains('select_multiple'))
        {
            $index = $type->search('select_multiple');
            $newRequest[$index] = json_encode($request[$index]);
        }
        return $newRequest;
    }
    public function store(Request $request)
    {
        dd(request()->all());

        $this->slug = $this->getSlug($request);

        $validation = collect();
        $this->getColumns()->each(function ($item, $index) use ($validation) {
                if(json_decode($item->validation) !== null)
                {
                    $validation->put($item->column,json_decode($item->validation));
                }
        });
        $this->validate($request, $validation->toArray());

        $newRequest = $this->exeptionsRequest($request);

        $model = Laramin::model($this->getDataType()->name)->create($newRequest);

        /**

            TODO:
            - Success Message Session FLash
         */

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
    public function update(Request $request, $id)
    {
        $this->slug = $this->getSlug($request);

        $newRequest = $this->exeptionsRequest($request);

        Laramin::model($this->getDataType()->name)->find($id)->update($newRequest);
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
        return redirect()->route("laramin.{$this->slug}.index");
    }
}
