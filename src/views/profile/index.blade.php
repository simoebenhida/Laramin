@extends('laramin::partials.main')

@section('title','Profile')
@section('styles')
{{-- <link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/tooltip.sass') }}"> --}}
@endsection
@section('content')

  <div class="column" style="position: relative;
    z-index: 9;
    text-align: center;">
<a href="#" class="tooltip is-tooltip-bottom" data-tooltip="Upload Picture">
    <img src="http://devma.net/storage/users/May2017/MudntFwPsxCUfRT8shhw.jpeg" class="avatar" style="border-radius:50%; width:150px; height:150px; border:5px solid #fff;" alt="mohamed benhida avatar">
</a>
     <p style="text-align: center;">{{ auth()->user()->name }}</p>
    <p style="text-align: center;">{{ auth()->user()->email }}</p>
</div>

@endsection
