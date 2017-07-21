<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.3/css/bulma.min.css">
	<link rel="stylesheet" type="text/css" href="{{ slblog_asset('css/style.css') }}">
	{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"> --}}
	<link rel="stylesheet" type="text/css" href="{{ slblog_asset('css/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ slblog_asset('css/dataTables.bootstrap.css')}}">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	@yield('styles')
</head>
<body>
	@include('slblog::partials.header')

	@yield('content')

	@include('slblog::partials.footer');
	<script type="text/javascript" src="{{ slblog_asset('js/jquery-2.1.4.min.js')}}"></script>
	{{-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> --}}

	<script type="text/javascript" src="{{ slblog_asset('js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{ slblog_asset('js/dataTables.bootstrap.min.js')}}"></script>

	@yield('scripts')
</body>
</html>