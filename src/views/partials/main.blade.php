<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<meta charset="utf-8" name="csrf-token" content="{{ csrf_token() }}">
	<meta charset="utf-8" name="auth-ID" content="@if(auth()->user()){{ auth()->user()->id }}@else null @endif">
	<meta charset="utf-8" name="prefix" content="{{ config('laramin.prefix') }}">
	<link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/bulma.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/style.css') }}">
	{{-- <link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/jquery.dataTables.min.css')}}"> --}}
	<link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/dataTables.bulma.css')}}">
	{{-- <link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/sweetalert2.min.css')}}"> --}}
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">

	@yield('styles')
</head>
<body>
	<div class="container" id="laramin_app">
	@include('laramin::partials.header')
	<div class="columns">
	@include('laramin::partials.menu')
	<div class="column is-10">
	@include('laramin::partials.message')
		@yield('content')
	</div>
	</div>
	</div>

	@include('laramin::partials.footer')
	<script type="text/javascript" src="{{ laramin_asset('js/jquery-2.1.4.min.js')}}"></script>
	<script type="text/javascript" src="{{ laramin_asset('js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{ laramin_asset('js/dataTables.bulma.min.js')}}"></script>
	{{-- <script type="text/javascript" src="{{ laramin_asset('js/app.js') }}"></script> --}}
	<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
	@yield('scripts')


</body>
</html>
