@extends('laramin::partials.main')

@section('title','Edit Profile')

@section('content')
<form method="post" action="" enctype="multipart/form-data">
<div class="columns m-t-100">
<div class="column is-8">
        <div class="column is-half is-offset-one-quarter">
            <label class="m-t-10">Name</label>
            <input type="text" class="input" name="name" value="{{ auth()->user()->name }}">
            <div class="m-t-20">
            <label>Email</label>
            <input type="text" class="input" name="email" value="{{ auth()->user()->email }}">
            </div>
            {{-- Add Model For Change Password --}}
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
