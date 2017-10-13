@extends('laramin::partials.main')

@section('title','Edit Profile')

@section('content')
<form method="post" action="{{ route('laramin.profile_editing') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}

<div class="columns m-t-100">
<div class="column is-8">
        <div class="column is-half is-offset-one-quarter">
            <label class="m-t-10">Name</label>
            <input type="text" class="input" name="name" value="{{ auth()->user()->name }}" class="@if($errors->has('name')) is-danger @endif">
            <p class="help is-danger">{{ $errors->first('name')}}</p>
            <div class="m-t-20">
            <label>Email</label>
            <input type="text" class="input" name="email" value="{{ auth()->user()->email }}" class="@if($errors->has('email')) is-danger @endif">
            <p class="help is-danger">{{ $errors->first('email')}}</p>
            </div>
            <changepassword></changepassword>
        </div>
</div>
<div class="column is-4">
    <img src="http://devma.net/storage/users/May2017/MudntFwPsxCUfRT8shhw.jpeg" height="150px">
    <input class="input" type="file" name="image">
</div>

</div>
<button type="submit" class="button is-primary">Edit</button>

@endsection
