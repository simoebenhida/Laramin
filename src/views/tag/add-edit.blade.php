@extends('slblog::partials.main')
{{-- TO DO : Edit Tag title status delete or add --}}

@section('title','Tag')

@section('content')
			<div class="column is-6 is-offset-3 m-t-100">
				<h1 class="title is-center">Tag</h1>
				<div class="card">
				<div class="card-content m-b-40">
				<form action="{{ route('slblog.tag.store') }}" method="post">
						{{ csrf_field() }}
					<div class="field">
						<label for="Name">Name</label>
							<p class="control">
						<input type="text" class="input @if($errors->has('name')) is-danger @endif" name="name">
						 <p class="help is-danger">{{ $errors->first('name') }}</p>
							</p>
					</div>
				<div class="field">
				<label for="Slug">Slug</label>
					<p class="control">
						<input type="text" class="input @if($errors->has('slug')) is-danger @endif" name="slug">
						 <p class="help is-danger">{{ $errors->first('slug') }}</p>
					</p>
				</div>
        				  <button type="submit" class="button is-success is-outlined is-fullwidth m-t-30">Save</button>
					</form>
					</div>
				</div>

			</div>

@endsection