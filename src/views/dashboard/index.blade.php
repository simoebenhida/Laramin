@extends('slblog::partials.main')

@section('title','Dashboard')

@section('content')
	<div class="columns">
	<div class="column is-4 m-t-100">
		<div class="card" style="background-color: #00d1b2">
			<div class="card-content">
				<h1 class="has-text-centered has-text-white size-t-2 m-t-120">Posts</h1>
				<div class="has-text-centered">
				<span class="tag is-light is-large is-fullwidth m-t-20">{{ SLblog::model('post')->count() }}</span>
				</div>
				<div class="has-text-centered m-t-20">
				<a href="#" class="button">Add New Post </a>
				</div>
			</div>
		</div>
	</div>

	<div class="column is-4 m-t-100">
		<div class="card" style="background-color: #00d1b2">
			<div class="card-content">
				<h1 class="has-text-centered has-text-white size-t-2 m-t-120">Tags</h1>
				<div class="has-text-centered">
				<span class="tag is-light is-large is-fullwidth m-t-20">{{ SLblog::model('tag')->count() }}</span>
				</div>
				<div class="has-text-centered m-t-20">
				<a href="#" class="button">Add New Tag </a>
				</div>
			</div>
		</div>
	</div>

	<div class="column is-4 m-t-100">
		<div class="card" style="background-color: #00d1b2">
			<div class="card-content">
				<h1 class="has-text-centered has-text-white size-t-2 m-t-120">Categories</h1>
				<div class="has-text-centered">
				<span class="tag is-light is-large is-fullwidth m-t-20">{{ SLblog::model('category')->count() }}</span>
				</div>
				<div class="has-text-centered m-t-20">
				<a href="#" class="button">Add New Category </a>
				</div>
			</div>
		</div>
	</div>
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
