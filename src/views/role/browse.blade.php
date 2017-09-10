@extends('laramin::partials.main')

@section('title','Roles')

@section('content')
  <rolepermission :proles="{{ Laramin::model('Role')->all()->toJson() }}" :models="{{ json_encode(Laramin::getAllModels())}}" :can="{{ json_encode(laramin_get_single_permission(auth()->user())) }}"></rolepermission>

@endsection
