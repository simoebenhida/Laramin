@extends('slblog::partials.main')

@section('title','User Permission')

@section('content')
<h1 class="title m-t-100">Users</h1>
          <userpermission :pusers="{{ json_encode(slblog_get_users()) }}" :roles="{{json_encode(slblog_get_roles())}}"></userpermission>
@endsection
