@extends('slblog::partials.main')

@section('title','Roles')

@section('content')

  <rolepermission :proles="{{ SLblog::model('Role')->all()->toJson() }}" :models="{{ json_encode(SLblog::getAllModels())}}"></rolepermission>
@endsection
