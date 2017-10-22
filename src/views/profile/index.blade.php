@extends('laramin::partials.main')

@section('title','Profile')
@section('styles')
{{-- <link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/tooltip.sass') }}"> --}}
@endsection
@section('content')

  <div class="column" style="position: relative;
    z-index: 9;
    text-align: center;">
<a href="{{ route('laramin.profile_edit')}}" class="tooltip is-tooltip-bottom" data-tooltip="Upload Picture">
    <img src="{{ Auth::user()->avatar }}" class="avatar" style="border-radius:50%; width:250px; border:5px solid #fff;" alt="{{ Auth::user()->name }} avatar">
</a>
     <p style="text-align: center;">{{ auth()->user()->name }}</p>
    <p style="text-align: center;">{{ auth()->user()->email }}</p>
</div>

@endsection
