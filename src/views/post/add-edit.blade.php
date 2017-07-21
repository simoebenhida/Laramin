@extends('slblog::partials.main')
{{-- TODO: Change Title with Type Variable Via Controller --}}
@section('title','Add Post')

@section('content')

<div class="card-content m-b-100">
	<form>
<div class="columns m-t-100 m-b-40">
	    <div class="column is-two-thirds">
		    <div class="field">
			<label for="title">Title</label>
			<p class="control">
				<input type="text" class="input titleI" placeholder="title" name="title">
			</p>
		  </div>
		  <div class="field">
		  <label for="content">Content</label>
			<textarea class="richTextBox" name="content"></textarea>
		</div>
		<div class="field">
		  <label for="description">Small Description</label>
			<textarea class="textarea" rows="4" name="description"></textarea>
		</div>
		<div class="field">
			<button class="button is-primary pull-right">Save Post</button>
		</div>
	</div>
	<div class="column">
		<div class="field">
			<label for="">Slug</label>
			<p class="control">
				<input type="text" id="slug" class="input" placeholder="Slug" name="slug">
			</p>
		</div>
		<div class="field m-t-40">
		<div class="select is-primary">
		  	 <select name="status">
		   	   <option value="PUBLISHED">PUBLISHED</option>
		 	   <option value="PENDING">PENDING</option>
		 	   <option value="DRAFT">DRAFT</option>
		  	</select>
		</div>
		</div>

		<div class="field m-t-40">
			<label class="checkbox">
			  <input type="checkbox">
			  	Featured
			</label>
		</div>
		<div class="field m-t-40">
		<label for="image">Image</label>
		<p class="control">
			<input type="file" class="input" name="image">
		</p>
		</div>

	</div>
</div>
	</form>
</div>

@endsection
@section('scripts')
	<script>
		$('document').ready(function () {
         		   $('#slug').slugify();
      		  });
	</script>

            <script src="{{ slblog_asset('js/tinymce/tinymce.min.js') }}"></script>
    	<script src="{{ slblog_asset('js/voyager_tinymce.js') }}"></script>
	<script src="{{ slblog_asset('js/slugify.js')}}"></script>

@endsection