<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<meta charset="utf-8" name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.3/css/bulma.min.css">
	<link rel="stylesheet" type="text/css" href="{{ slblog_asset('css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ slblog_asset('css/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ slblog_asset('css/dataTables.bulma.css')}}">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">

	@yield('styles')
</head>
<body>
	@include('slblog::partials.header')

	<div class="columns" id="slblog_app">
	@include('slblog::partials.menu')
	<div class="column">
	@yield('content')
	</div>
	</div>

	@include('slblog::partials.footer');
	<script type="text/javascript" src="{{ slblog_asset('js/jquery-2.1.4.min.js')}}"></script>
	<script type="text/javascript" src="{{ slblog_asset('js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{ slblog_asset('js/dataTables.bulma.min.js')}}"></script>
	{{-- <script src="https://unpkg.com/vue"></script> --}}
	<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
	@yield('scripts')
</body>
</html>