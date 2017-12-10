<!DOCTYPE html>
<html>
<head>
    <title>{{ $status.' '.$type->name }}</title>
    <meta charset="utf-8" name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" name="auth-ID" content="@if(auth()->user()){{ auth()->user()->id }}@else null @endif">
    <meta charset="utf-8" name="prefix" content="{{ config('laramin.prefix') }}">
    <link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/bulma.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/dataTables.bulma.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">

</head>
<body class="layout-default">
<div class="container">
    @include('laramin::partials.header')
    <div class="columns">
        <div id="laramin_app" class="column is-2">
            <laraminthemenu
                    :menus='{{ json_encode(laramin_menu_models()) }}'
                    prefix="{{ config('laramin.prefix') }}"
                    :active="{{ json_encode(laramin_get_active_menu()) }}"
                    :permission="{{ json_encode(laramin_read_permission_menu()) }}"></laraminthemenu>
        </div>


        <div class="column is-10">
            @include('laramin::partials.message')
            <form method="POST" action="@if($status == 'Add') {{ route('laramin.'. $type->slug .'.store') }} @else {{ route('laramin.'. $type->slug .'.update',$item->id) }} @endif" enctype="multipart/form-data">

                {{ csrf_field() }}
                @if($status == 'Edit')
                    {{ method_field('PUT') }}
                @endif

                <h1 class="title m-t-100">{{ $status}} {{ $type->name }}</h1>
                <div class="columns is-multiline">
                    @if($status == 'Add')

                        @foreach ($columns as $column)
                            @if($column->type == 'rich_text_box')
                                <div class="column is-full">
                                    @else
                                        <div class="column is-half">
                                            @endif
                                            @include('laramin::forms.'.$column->type,[
                                            'name' => $column->column,
                                            'value' => '',
                                            'details' => $column->details,
                                            'id' => null
                                            ])
                                        </div>
                                        @endforeach

                                        @else

                                            @foreach ($columns as $column)
                                                @if($column->type == 'rich_text_box')
                                                    <div class="column is-full">
                                                        @else
                                                            <div class="column is-half">
                                                                @endif
                                                                @include('laramin::forms.'.$column->type,[
                                                                'name' => $column->column,
                                                                'value' => $item[$column->column],
                                                                'details' => $column->details,
                                                                'id' => $item->id
                                                                ])
                                                            </div>
                                                            @endforeach

                                                        @endif
                                                    </div>

                                                    <div class="field">
                                                        <button type="submit" class="button is-primary">{{ $status == 'Add' ? 'Save'  : 'Update' }}</button>
                                                    </div>

            </form>
        </div>
    </div>
</div>

@include('laramin::partials.footer')
<script type="text/javascript" src="{{ laramin_asset('js/jquery-2.1.4.min.js')}}"></script>
<script type="text/javascript" src="{{ laramin_asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{ laramin_asset('js/dataTables.bulma.min.js')}}"></script>
<script type="text/javascript" src="{{ laramin_asset('js/app.js') }}"></script>
<script src="{{ laramin_asset('js/slugify.js')}}"></script>
<script src="{{ laramin_asset('js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ laramin_asset('js/laramin_tinymce.js') }}"></script>
<script type="text/javascript" src="{{ laramin_asset('js/select2.min.js')}}"></script>

<script>
    $('document').ready(function () {
        $('#slug').slugify();
        $('.select2').select2();
    });
</script>
<script>
    new Vue({
        el : '#laramin_image',
        components : {
            formimagepreview : formImage
        }
    });

    new Vue({
        el : '#laramin_tag',
        components : {
            tagselect : tags
        }
    });

</script>
</body>
</html>

