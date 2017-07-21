@extends('slblog::partials.main')
@section('title','Home')

@section('content')

	<div class="columns">
  	<div class="column is-half is-offset-one-quarter m-t-100">
  		<div class="card">
  			<div class="card-content">
  				<h1 class="title">Log In</h1>
  				<form>
  				<div class="field">
  					<label>Email</label>
  					<p class="control">
  						<input type="text" class="input" placeholder="Email">
  					</p>
  				</div>
  				</form>
  			</div>
  		</div>
  	</div>
	</div>

@endsection