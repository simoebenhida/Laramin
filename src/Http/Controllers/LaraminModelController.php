<?php

namespace Simoja\Laramin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Simoja\Laramin\Facades\Laramin;
use Simoja\Laramin\Traits\LaraminModel;

class LaraminModelController extends Controller
{
    use LaraminModel;
    protected $newRequest;
    protected $slug;
    protected $type;

    public function __construct(Request $request)
    {
        $this->slug = $this->getSlug($request);
        $this->type = Laramin::model('DataType')->where('slug', $this->slug)->first();
    }

    public function index(Request $request)
    {
        if (!$this->can('read-' . Str::plural($this->slug), auth()->user()->id)) {
            abort(404);
        }
        return view('laramin::models.browse')
            ->withItems($this->items())
            ->withColumns($this->displayedColumns())
            ->withType($this->type);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$this->can('create-' . Str::plural($this->slug), auth()->user()->id)) {
            abort(404);
        }

        return view('laramin::models.add-edit')
            ->withStatus('Add')
            ->withColumns($this->columns())
            ->withType($this->type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$this->can('create-' . Str::plural($this->slug), auth()->user()->id)) {
            abort(404);
        }
        // $this->newRequest = $request->all();

        $this->validation($request);

        $request = $this->HandleRequest($request);

        $model = Laramin::model($this->type->name)->create($request->toArray());

        // $this->relationAfterSaving($request, $model, $this->getInfoOfType(), true);

        Session::flash($this->flashname, $this->SessionMessage("Your {$this->slug} Has Been Succesfully Added", 'success'));

        return redirect()->route('laramin.' . $this->slug . '.index');
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
    public function edit(Request $request, $id)
    {
        if (!$this->can('update-' . Str::plural($this->slug), auth()->user()->id)) {
            abort(404);
        }

        return view('laramin::models.add-edit')
            ->withItem($this->item($id))
            ->withStatus('Edit')
            ->withColumns($this->columns())
            ->withType($this->type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function checkUpdateValues($request, $item, $type)
    {
        $remove = collect();
        if ($type->contains('image')) {
            $index = $type->search('image');
            if (is_null($request[$index])) {
                $this->newRequest[$index] = $item[$index];
                $remove->push('image');
            } else {
                $this->newRequest[$index] = $this->uploadImage($request[$index]);
            }
        }
        return $remove;
    }

    public function update(Request $request, $id)
    {
        if (!$this->can('update-' . Str::plural($this->slug), auth()->user()->id)) {
            abort(404);
        }
        // $this->newRequest = $request->all();

        $model = Laramin::model($this->type->name)->find($id);

        $this->validation($request, $model->id);

        $model->update($request->toArray());

        // $this->relationAfterSaving($request, $itemById, $this->getInfoOfType(), false);

        Session::flash($this->flashname, $this->SessionMessage("Your {$this->slug} Has Been Succesfully Edited", 'success'));


        return redirect()->route("laramin.{$this->slug}.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->slug = $this->getSlug($request);
        if (!$this->can('delete-' . Str::plural($this->slug), auth()->user()->id)) {
            abort(404);
        }
        Laramin::model($this->type->name)->find($id)->delete();

        Session::flash($this->flashname, $this->SessionMessage("Your {$this->slug} Has Been Succesfully Destroyed", 'success'));

        return redirect()->route("laramin.{$this->slug}.index");
    }
}
