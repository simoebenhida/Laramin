@extends('laramin::partials.main')
{{-- TODO: Change Title with Type Variable Via Controller --}}
@section('title','Add Post')

@section('content')
	<div class="columns">
	<div class="column is-7 m-t-100" id="app">
		<form action="{{ route('laramin.post.store') }}" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
			<h1 class="title">Add Post</h1>

		    <div class="field">
			<label for="title">Title</label>
			<p class="control">
				<input type="text" id="title" class="input @if($errors->has('title')) is-danger @endif" placeholder="Title" name="title" value="{{ old('title')}}">
			</p>
			 <p class="help is-danger">{{ $errors->first('title') }}</p>
		  </div>

		  <div class="field">
		  <label for="content">Content</label>
			<textarea class="richTextBox @if($errors->has('content')) is-danger @endif" name="content">{{ old('content') }}</textarea>
			 <p class="help is-danger">{{ $errors->first('content') }}</p>
		</div>

		<div class="field">
		  <label for="description">Small Description</label>
			<textarea class="textarea @if($errors->has('description')) is-danger @endif" rows="4" name="description"> {{ old('description') }}</textarea>
			 <p class="help is-danger">{{ $errors->first('description') }}</p>
		</div>

		<div class="field">
			<button type="submit" class="button is-primary pull-right">Save Post</button>
		</div>
	</div>
	<div class="column is-5 m-t-160">
		<div class="field">
			<label for="">Slug</label>
			<p class="control">
				<input type="text" id="slug" class="input @if($errors->has('slug')) is-danger @endif" placeholder="Slug" name="slug" value="{{ old('slug')}}">
				 <p class="help is-danger">{{ $errors->first('slug') }}</p>
			</p>
		</div>
		<div class="field m-t-40">
		<div class="select is-primary">
		  	 <select name="status">
		   	   <option @if(old('status') == 'PUBLISHED') selected="selected" @endif value="PUBLISHED">PUBLISHED</option>
		 	   <option @if(old('status') == 'PENDING') selected="selected" @endif value="PENDING">PENDING</option>
		 	   <option @if(old('status') == 'DRAFT') selected="selected" @endif value="DRAFT">DRAFT</option>
		  	</select>
		</div>
		</div>

		<div class="field m-t-40">
			<label for="featured" class="checkbox">
			  <input type="checkbox" name="featured" value="true">
			  	Featured
			</label>
		</div>

		<div class="field m-t-40">
		<label for="image">Image</label>
		<p class="control">
			<input type="file" class="input @if($errors->has('image')) is-danger @endif" name="image">
				 <p class="help is-danger">{{ $errors->first('image') }}</p>
		</p>
		</div>

	</div>
	</form>

	</div>


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
	<script>
		new Vue({
			 el: '#app',
			 data : {
			 	featured : ''
			 },
			 methods : {
			 	clickCheckBox() {
			 		console.log('clicked');
			 	}
			 }
		});
	</script>
@endsection
