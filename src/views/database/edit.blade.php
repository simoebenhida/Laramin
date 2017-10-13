@extends('laramin::partials.main')

@section('title','Edit '. $type->name)
@section('styles')
<style type="text/css" media="screen">
.ace_editor.min_height_150{
  min-height:150px;
  width:100%;
}
</style>
@endsection
@section('content')
    <h1 class="title m-t-100">Edit Database Table</h1>
<form method="post" action="{{ route('laramin.database.update',$type->id)}}">
{{ csrf_field() }}
<div class="columns">
  <div class="column is-3 m-t-10">
 <div class="field">
      <label for="name"> Table Name</label>
      <p class="control">
      <input type="text" class="input" placeholder="Name" name="name" value="{{ $type->name }}" disabled="">
      </p>
    </div>
 </div>

<div class="column is-3 m-t-10">
 <div class="field">
      <label for="name"> Model Name</label>
      <p class="control">
      <input type="text" class="input" placeholder="Model" name="model" value="{{ $type->model }}" disabled="">
      </p>
    </div>
 </div>

 <div class="column is-3 m-t-10">
 <div class="field">
      <label for="name"> Slug</label>
      <p class="control">
      <input type="text" class="input" placeholder="Slug" name="slug" value="{{ $type->slug }}" disabled="">
      </p>
    </div>
 </div>

  <div class="column is-3 m-t-10">
    <div class="field">
    <label class="checkbox" style="margin-top: 26px;">
          <input type="checkbox" name="menu" @if($type->menu) checked @endif value="1">
            Display On Menu
        </label>
    </div>
  </div>

</div>
@foreach($type->infos as $info)
<div class="columns">
<div class="column is-3 m-t-10">
 <div class="field">
      <label for="name">Column</label>
      <p class="control">
      <input type="text" class="input" placeholder="Column" name="{{ 'column_'. $info->id}}" value="{{ $info->column }}" disabled="">
      </p>
    </div>
 </div>

<div class="column is-3 m-t-10">
 <div class="field">
      <label for="name"> Type</label>
      <p class="control">
      <input type="text" class="input" placeholder="Type" name="{{ 'type_'. $info->id}}" value="{{ $info->type }}" disabled="">
      </p>
    </div>
 </div>

<div class="column is-3 m-t-10">
      <label for="name">{{ $info->validation == null ? 'Details' : 'Validation'}}</label>
<div class="ace_editor min_height_150" id="{{ $info->id }}">{{ $info->validation == null ? $info->details : $info->validation}}</div>
<textarea name="{{ $info->validation == null ? 'details_'.$info->id : 'validation_'.$info->id }}" id="{{ $info->id.'_textarea' }}" style="display: none">{{ $info->validation == null ? $info->details : $info->validation}}</textarea>
 </div>

  <div class="column is-3 m-t-10">
    <div class="field">
    <label class="checkbox" style="margin-top: 40px;">
          <input type="checkbox" name="{{ 'display_'.$info->id }}" @if($info->display) checked @endif value="1">
            Display On Array
        </label>
    </div>
  </div>

</div>
@endforeach
<button role="button" type="submit" class="button is-primary">
    <span class="icon is-small">
      <i class="fa fa-check"></i>
    </span>
    <span>Update</span>
  </button>
  </form>

@endsection

@section('scripts')
   <script src="{{ laramin_asset('js/ace/ace.js') }}"></script>
   <script src="{{ laramin_asset('js/laramin_ace_editor.js') }}"></script>
{{--    <script src="{{ laramin_asset('js/slugify.js')}}"></script>

  <script>
      $('document').ready(function () {
                 $('#slug').slugify();
            });
  </script> --}}
@endsection
