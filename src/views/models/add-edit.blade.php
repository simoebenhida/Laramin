@extends('laramin::partials.main')

@section('title',$status.' '.$type->name)

@section('content')

        <form method="POST" action="@if($status == 'Add') {{ route('laramin.'. $type->slug .'.store') }} @else {{ route('laramin.'. $type->slug .'.update',$item->id) }} @endif" enctype="multipart/form-data">
                {{ csrf_field() }}

              @if($status == 'Edit')
                {{ method_field('PUT') }}
                @endif

            <h1 class="title m-t-100">{{ $status}} {{ $type->name }}</h1>
                 <div class="columns is-multiline">

            @if($status == 'Add')
            @foreach ($columns as $column)
                @include('laramin::forms.'.$column->type,[
                'name' => $column->column,
                'value' => '',
                'details' => $column->details
                ])
            @endforeach
            @else
            @foreach ($columns as $column)
                @include('laramin::forms.'.$column->type,[
                'name' => $column->column,
                'value' => $item[$column->column],
                'details' => $column->details
                ])
            @endforeach
            @endif
                </div>

        <div class="field">
            <button type="submit" class="button is-primary">{{ $status == 'Add' ? 'Save'  : 'Update' }}</button>
        </div>

    </form>

@endsection
@section('scripts')
    <script src="{{ laramin_asset('js/slugify.js')}}"></script>
     <script src="{{ laramin_asset('js/tinymce/tinymce.min.js') }}"></script>
     <script src="{{ laramin_asset('js/voyager_tinymce.js') }}"></script>
    <script>
        $('document').ready(function () {
                   $('#slug').slugify();
              });
    </script>
@endsection
