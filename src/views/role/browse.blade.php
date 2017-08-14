@extends('slblog::partials.main')

@section('title','Roles')

@section('content')

  <rolepermission :roles="{{ SLblog::model('Role')->all()->toJson() }}"></rolepermission>
@endsection
