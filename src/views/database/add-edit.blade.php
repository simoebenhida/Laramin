@extends('slblog::partials.main')

@section('title','Add Type')

@section('content')
    <h1 class="title m-t-100">Add Database Table</h1>
    <div id="slblog_database">
    <slblogdatabase prefix="{{ config('SLblog.prefix') }}" :basictypes="{{ json_encode(slblog_basic_types()) }}"></slblogdatabase>
    </div>
@endsection
