@extends('laramin::partials.main')

@section('title','Add Type')

@section('content')
    <h1 class="title m-t-100">Add Database Table</h1>
    <div id="laramin_database">
    <laramindatabase :basictypes="{{ json_encode(laramin_basic_types()) }}"></laramindatabase>
    </div>
@endsection
{{-- @section('scripts')
    <script src="{{ laramin_asset('js/slugify.js')}}"></script>
    <script>
        $('document').ready(function () {
                   $('#slug').slugify({
                    'input' : $('#nameType'),
                   });
              });
    </script>
@endsection
 --}}
