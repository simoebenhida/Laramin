@extends('laramin::partials.main')

@section('title','Dashboard')

@section('content')
	<div class="columns">
@foreach(laramin_menu_dashboard() as $key => $model)
	<div class="column is-4 m-t-100">
		<div class="card" style="background-color: #00d1b2">
			<div class="card-content">
				<h1 class="has-text-centered has-text-white size-t-2 m-t-120">{{ $model->name }}</h1>
				<div class="has-text-centered">
				<span class="tag is-light is-large is-fullwidth m-t-20">{{ Laramin::model($model->name)->count() }}</span>
				</div>
				<div class="has-text-centered m-t-20">
				<a href="{{ route("laramin.{$model->slug}.index")}}" class="button">Add New {{ $model->name }} </a>
				</div>
			</div>
		</div>
	</div>
@endforeach

	</div>
	<div class="columns">
		<div class="column">
		{{-- /**

			TODO:
			- Google Api

		 */ --}}
			<h1 class="has-text-centered">Google Api For Later</h1>
		</div>
	</div>

@endsection
