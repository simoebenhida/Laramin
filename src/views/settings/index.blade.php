@extends('laramin::partials.main')

@section('title','Settings')

@section('content')
    <h1 class="title m-t-100">Settings</h1>

<form method="post" action="{{ route('laramin.settings_edit') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}

<div class="columns">
<div class="column is-8 is-offset-2">
          @foreach ($settings as $setting)
                <code>Laramin::setting({{ "'{$setting->key}'" }})</code> => {{ Laramin::setting($setting->key) }}
                @include('laramin::forms.'.$setting->type,[
                'name' => $setting->key,
                'value' => $setting->value,
                'details' => null,
                'id' => null
                ])
            @endforeach
</div>

</div>

@if(Auth::user()->can('update-settings'))
<button type="submit" class="button is-primary is-pulled-right">Save Settings</button>
@endif

@endsection
