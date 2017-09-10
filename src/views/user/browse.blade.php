@extends('laramin::partials.main')

@section('title','User Permission')

@section('content')
          <userpermission :pusers="{{ json_encode(laramin_get_users()) }}" :roles="{{json_encode(laramin_get_roles())}}" :can="{{ json_encode(laramin_get_single_permission(auth()->user())) }}"></userpermission>
@endsection
